<?php

use App\Models\Hirarchy;
use App\Models\Member;
use App\Models\PackageLevel;
use App\Models\Epin;
use App\Models\Wallet;
use App\Models\Setting;
use App\Models\Incentive;

function location_finder($sponsor, $position){
	$pos_name = $position.'_leg_id';
	$downline = Hirarchy::select($pos_name)->where('member_id', $sponsor)->first();

	if($downline && $downline->pos_name){
		return $this->location_finder($downline->pos_name, $position);
	}

	return $sponsor;
}

function dateDiffInDays($date1, $date2) 
{
    // Calculating the difference in timestamps
    $diff = strtotime($date2) - strtotime($date1);
      
    // 1 day = 24 hours
    // 24 * 60 * 60 = 86400 seconds
    return abs(round($diff / 86400));
}

// function to generate random string
function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

// function to generate random number
function generateRandomNumber($length = 10) {
	$characters = '0123456789';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

// function to activate member account
function activateMember($member_id, $activated_by, $epin_code, $account_type){

	$epin_row = Epin::where('epin_code', $epin_code)->where('status', 0)->first();
	$hirarchy = Hirarchy::where('member_id', $member_id)->where('activation_amount', 0)->first();

	if($epin_row){
		if($hirarchy){

			// make updates in hirarchies table
			$hirarchy->activation_amount = $epin_row->amount;
			$hirarchy->activation_time = now();
			$hirarchy->package_id = $epin_row->package_id;
			$hirarchy->income = 1;
			$hirarchy->save();

			// make updates in epins table
			$epin_row->status = 1;
			$epin_row->used_by = $member_id;
			$epin_row->used_at = now();
			$epin_row->account_type = $account_type;
			$epin_row->activated_by = $activated_by;
			$epin_row->week_day = date('D', time());
			$epin_row->month_day = date('d', time());
			$epin_row->total = 0;
			$epin_row->save();

			return response()->json(['status' => true, 'message' => 'Account activated successfully.']);
		
		}else{
			return response()->json(['status' => false, 'message' => 'Selected Username is already active']);
		}
	}else{
		return response()->json(['status' => false, 'message' => 'Invalid Epin Code']);
	}

}

// function to check URL is youtube or not
function isYoutubeUrl($url){
	if(strpos($url, 'youtube') !== false){
		return true;
	}else{
		return false;
	}
}

// function to get youtube video id from url
function getYoutubeVideoId($url){
	$result = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
	if ($result) {
		return $match[1];
	}
	return false;
}

// function to check if a module is blocked or not
function isModuleBlocked($module_name){
	$setting = Setting::find(1);

	$column_name = $module_name.'_blocked';

	if($setting->$column_name == 1){
		return true;
	}else{
		return false;
	}
	
}

//distribute package level bonus
function distributeLevelIncome($member_id, $level, $incentiveName, $incentiveFor){
            
	$hirarchy_row = Hirarchy::select('id','member_id', 'sponsor_id', 'income', 'total_income', 'wallet_1', 'package_id')->where('member_id', $member_id)->first();

	$member_row = Member::select('id', 'member_id', 'status')->where('member_id', $member_id)->first();

	$max_payout = checkMaxPayout($member_id, $hirarchy_row->package_id, $hirarchy_row->total_income);

	if($level <= env('INCOME_LEVELS')){

		$total_directs = Hirarchy::where('sponsor_id', $member_id)->where('activation_amount', '>', 0)->count();

		$required_directs = PackageLevel::where('level', '<=', $level)->where('package_id', $hirarchy_row->package_id)->sum('direct_referrals');

		if($member_row->status && $hirarchy_row->income && $total_directs >= $required_directs && $max_payout === FALSE){
			
			$level_income = PackageLevel::where('level', $level)->where('package_id', $hirarchy_row->package_id)->pluck('amount')->first();
			$net_income = $level_income; //if there's deductions deduct here

			if($net_income > 0){

				//insert into incentives
				$incentive = new Incentive;
				$incentive->member_id = $member_row->id;
				$incentive->username = $member_id;
				$incentive->amount = $level_income;
				$incentive->deduction = 0;
				$incentive->net = $net_income;
				$incentive->incentive_name = $incentiveName;
				$incentive->incentive_info = 'Level '.$level;
				$incentive->incentive_for = $incentiveFor;
				$incentive->save();

				//insert into wallet
				$wallet = new Wallet;
				$wallet->member_id = $member_row->id;
				$wallet->username = $member_id;
				$wallet->amount = $level_income;
				$wallet->deduction = 0;
				$wallet->net = $net_income;
				$wallet->type = 'credit';
				$wallet->remark = $incentiveName;
				$wallet->wallet_type = 1;
				$wallet->save();

				//update total income field in hierarchy
				$hirarchy_row->total_income = $hirarchy_row->total_income + $level_income;
				$hirarchy_row->wallet_1 = $hirarchy_row->wallet_1 + $level_income;
				$hirarchy_row->save();

			}
		}

		//if sponsor id is present proceed
		if(!empty($hirarchy_row->sponsor_id)){
			return distributeLevelIncome($hirarchy_row->sponsor_id, $level+1, $incentiveName, $member_id);
		}
	}

}

//check if user have reached max payout
function checkMaxPayout($member_id, $package_id, $total_income){

	$package_row = Package::where('id', $package_id)->first();
	$max_payout = $package_row->amount * 10;

	if($total_income >= $max_payout){
		return FALSE;
	}else{
		return TRUE;
	}
}