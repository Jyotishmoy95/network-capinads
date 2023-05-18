<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Member;
use App\Models\Hirarchy;
use App\Models\Wallet;
use App\Models\Package;
use App\Models\Activation;
use App\Models\Incentive;
use App\Models\PackageLevel;
use App\Http\Requests\Activations\NewActivation;


class ActivationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:member');
    }

    public function new()
    {
        $packages = Package::where('status', 1)->get();
        return view('members.pages.activation.new', compact('packages'));
    }

    public function index()
    {
        return view('members.pages.activation.report');
    }

    // New activation request
    public function newActivation(NewActivation $request)
    {

        if(isModuleBlocked('activation')){
            $errors = ['member_id' => 'Oops! Something went wrong. Please try again later.'];
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }

        $income_name = json_decode(env('INCOME_TYPES'), true);
        $validated = $request->validated();
        $hirarchy = Hirarchy::where('member_id', $validated['member_id'])->first();
        $package = Package::where('status', 1)->where('id', $validated['package'])->firstOrFail();
        $member = Member::where('member_id', $validated['member_id'])->firstOrFail();

        $session_user = Hirarchy::where('member_id', auth()->user()->member_id)->first();

        if($session_user->wallet_3 < $package->amount){
            $errors = ['package' => 'Insufficient balance.'];
            return response()->json(['status' => false, 'errors' => $errors], 400);
        }

        if(!$member->documents){
            $errors = ['member_id' => 'Member have not upload his documents.'];
            return response()->json(['status' => false, 'errors' => $errors], 400);
        }
        
        if($hirarchy->activation_amount > 0){
            // $hirarchy->activation_amount = $hirarchy->activation_amount + $validated['amount'];
            // $hirarchy->last_topup_time = now();
            $errors = ['member_id' => 'Member already active'];
            return response()->json(['status' => false, 'errors' => $errors], 400);
        }else{
            $hirarchy->activation_amount = $package->amount;
            $hirarchy->activation_time = now();
        }
        
        $hirarchy->income = 1;
        $hirarchy->package_id = $validated['package'];
        $hirarchy->save();

        $session_user->wallet_3  = $session_user->wallet_3 - $package->amount;
        $session_user->save();

        //insert in activations table
        $activation = new Activation;
        $activation->member_id = $validated['member_id'];
        $activation->amount = $package->amount;
        $activation->activated_by = auth()->user()->id;
        $activation->account_type = 'user';
        $activation->topup_count =  0; //Activation::where('member_id', $validated['member_id'])->count() + 1;
        $activation->total_roi = 0;
        $activation->wallet_type = 3;
        $activation->next_roi = NULL; //date('Y-m-d 00:00:00', strtotime('+1 month')); 
        $activation->roi_percent = 0;
        $activation->save();

        //if sponsor id is present proceed
        // if(!empty($hirarchy->sponsor_id)){
        //     distributeLevelIncome($hirarchy->sponsor_id, 1, $income_name['5'], $hirarchy->member_id);
        // }
        distributeLevelIncome($validated['member_id'], 1, $income_name['5'], $hirarchy->member_id);

        return response()->json(['status' => true, 'message' => 'Account activated successfully.']);
    }

    // Get all activation report
    public function list(Request $request){
        if ($request->ajax()) {
            $data = Activation::select('member_id', 'activated_by', 'amount', 'created_at', 'account_type')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->with(['activatedByAdmin' => function($query){
                $query->select('id', 'name');
            }])
            ->with(['activatedByMember' => function($query){
                $query->select('id', 'full_name', 'member_id');
            }])
            ->where('account_type', 'user')
            ->where('activated_by', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

}
