<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Setting;
use App\Http\Requests\Member\Ads\ViewComplete;
use App\Models\AdReport;
use App\Models\Incentive;
use App\Models\Wallet;
use App\Models\Hirarchy;
use App\Models\Member;
use App\Models\Package;
use App\Models\PackageLevel;
use App\Models\AdLevelIncome;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:member');
    }

    public function index(){
        $total_ads = Ad::where('status', 1)->count();
        $viewed_ads = AdReport::where('member_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->count();
        $remaining_ads = $total_ads - $viewed_ads;

        $ads_viewed = AdReport::select('ad_id')->where('member_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'desc')->get();
        $active_ads = Ad::select('id')->where('status', 1)->get();

        // Viewed Ad IDs
        $viewed_ad_ids = [];
        foreach($ads_viewed as $ad){
            $viewed_ad_ids[] = $ad->ad_id;
        }
        // Active Ad IDs
        $active_ad_ids = [];
        foreach($active_ads as $ad){
            $active_ad_ids[] = $ad->id;
        }
        // Get the remaining ads
        $ads_to_view = array_values(array_diff($active_ad_ids, $viewed_ad_ids));

        return view('members.pages.ads.index', compact('total_ads', 'viewed_ads', 'remaining_ads', 'ads_to_view'));
    }

    public function show($id){
        $ad = Ad::where('status', 1)->findOrFail($id);
        $isAlreadyViewed = AdReport::where('member_id', auth()->user()->id)->where('ad_id', $id)->whereDate('created_at', date('Y-m-d'))->count();
        return view('members.pages.ads.view', compact('ad', 'isAlreadyViewed'));
    }


    public function viewComplete(ViewComplete $request)
    {   
        $ad = Ad::findOrFail($request->id);

        $already_viewed = AdReport::where('member_id', auth()->user()->id)->where('ad_id', $ad->id)->whereDate('created_at', date('Y-m-d'))->first();

        // Ad Income Credit Type
        $settings = Setting::select('income_credit_type')->find(1);

        if(!$already_viewed){
            $ad_report = new AdReport;
            $ad_report->member_id = auth()->user()->id;
            $ad_report->username = auth()->user()->member_id;
            $ad_report->ad_id = $ad->id;
            $ad_report->save();
            
            if($settings->income_credit_type == 'one'){
                // Credit Ad Income To Member Account
                $this->giveAdViewIncome();
            }
        }

        if($settings->income_credit_type == 'all'){
            $total_active_ads = Ad::where('status', 1)->count();
            $viewed_ads = AdReport::where('member_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->count();
            if($total_active_ads == $viewed_ads){
                // Credit Ad Income To Member Account
                $this->giveAdViewIncome();
            }
        }

        return response()->json(['success' => true]);

    }

    protected function giveAdViewIncome(){

        $income_name = json_decode(env('INCOME_TYPES'), true);

        $user = auth()->user();

        $memberStatus = $user->status;
        $hirarchyRow = Hirarchy::select('id', 'income', 'sponsor_id', 'activation_amount', 'total_income', 'wallet_1', 'package_id')->where('member_id', $user->member_id)->firstOrFail();

        //is max payout reached
        $max_payout = checkMaxPayout($user->member_id, $hirarchyRow->package_id,  $hirarchyRow->total_income);

        if($memberStatus == 1 && $hirarchyRow->income && $max_payout === FALSE){
            //$settings = Setting::select('self_income', 'admin_charges')->find(1); //self income & admin charges
            $package = Package::find($hirarchy_row->package_id);
            $net_income = $package->self_ad_income; //net income after deductions

            if($package->self_ad_income > 0){
                //insert into incentives
                $incentive = new Incentive;
                $incentive->member_id = $user->id;
                $incentive->username = $user->member_id;
                $incentive->amount = $package->self_ad_income;
                $incentive->deduction = 0;
                $incentive->net = $net_income;
                $incentive->incentive_name = $income_name['1'];
                $incentive->incentive_for = 'ad_view';
                $incentive->save();

                //insert into wallet
                $wallet = new Wallet;
                $wallet->member_id = $user->id;
                $wallet->username = $user->member_id;
                $wallet->amount = $package->self_ad_income;
                $wallet->deduction = 0; //$settings->admin_charges
                $wallet->net = $net_income;
                $wallet->type = 'credit';
                $wallet->remark = $income_name['1'];
                $wallet->wallet_type = 1;
                $wallet->save();

                //update total income field in hierarchy
                $hirarchyRow->total_income = $hirarchyRow->total_income + $net_income;
                $hirarchyRow->wallet_1 = $hirarchyRow->wallet_1 + $net_income;
                $hirarchyRow->save();
            }
        }

        //if sponsor id is present proceed
        if(!empty($hirarchyRow->sponsor_id)){
            $this->giveLevelIncome($hirarchyRow->sponsor_id, 1, $income_name['2'], $user->member_id);
        }

        // $this->giveLevelIncome($user->member_id, 1, $income_name['2'], $user->member_id);

    }

    protected function giveLevelIncome($member_id, $level, $incentiveName, $incentiveFor){
        
        $hirarchy_row = Hirarchy::select('id','member_id', 'sponsor_id', 'income', 'total_income', 'wallet_1', 'package_id')->where('member_id', $member_id)->first();
        $member_row = Member::select('id', 'member_id', 'status')->where('member_id', $member_id)->first();

        $total_directs = Hirarchy::where('sponsor_id', $member_id)->where('activation_amount', '>', 0)->count();

        $required_directs = PackageLevel::where('level', '<=', $level)->where('package_id', $hirarchy_row->package_id)->sum('direct_referrals');

        if($level <= env('AD_LEVELS')){
            if($member_row->status && $hirarchy_row->income && $total_directs >= $required_directs){
                
                $level_income = AdLevelIncome::where('level', $level)->where('package_id', $hirarchy_row->package_id)->pluck('amount')->first();
                $net_income = $level_income; //if there's deductions deduct here

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

            //if sponsor id is present proceed
            if(!empty($hirarchy_row->sponsor_id)){
                $this->giveLevelIncome($hirarchy_row->sponsor_id, $level+1, $incentiveName, $member_id);
            }
        }

    }

}
