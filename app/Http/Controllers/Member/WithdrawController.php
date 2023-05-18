<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use DataTables;
use App\Models\Hirarchy;
use App\Models\Setting;
use App\Models\MemberBankDetail;
use App\Http\Requests\Member\Withdraw\NewWithdraw;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:member');
    }

    public function index()
    {
        return view('members.pages.withdrawals.list');
    }

    public function newWithdraw()
    {
        $available_balance = Hirarchy::where('member_id', auth()->user()->member_id)->first()->wallet_1;
        $bank_details = MemberBankDetail::where('member_id', auth()->user()->member_id)->first();
        return view('members.pages.withdrawals.new', compact('available_balance', 'bank_details'));
    }

    public function withdrawList(Request $request)
    {
        if ($request->ajax()) {

            $sdate = $request->sdate;
            $edate = $request->edate;

            $data = Wallet::select('id', 'member_id', 'username', 'net', 'amount', 'deduction', 'type', 'remark', 'created_at')
            ->where('username', auth()->user()->member_id)
            ->where('type', 'debit')
            ->filterDate($sdate, $edate)
            ->orderBy('created_at', 'desc')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function($query){ 
                    $date = date('d-m-Y h:i A', strtotime($query->created_at));
                    return $date;
                })
                ->addColumn('status', function($query){ 
                    $status = $query->status;

                    if($status == 0){
                        $status = '<span class="badge badge-dark">Pending</span>';
                    }elseif($status == 2){
                        $status = '<span class="badge badge-success">Paid</span>';
                    }elseif($status == 2){
                        $status = '<span class="badge badge-danger">Rejected</span>';
                    }

                    return $status;
                })
                ->rawColumns(['date', 'status'])
                ->make(true);
        }
    }

    public function withdraw(NewWithdraw $request)
    {

        if(isModuleBlocked('withdrawal')){
            $errors = ['amount' => 'Oops! Something went wrong. Please try again later.'];
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }
        
        $available_balance = Hirarchy::where('member_id', auth()->user()->member_id)->first()->wallet_1;

        if($request->amount > $available_balance){
            $errors = ['amount' => 'Insufficient Balance'];
            return response()->json(['status' => false, 'errors' => $errors], 400);
        }

        //admin charges from settings table
        $admin_charges = Setting::find(1)->admin_charges;

        $charge_amount = round(($request->amount * $admin_charges) / 100, 2);

        $wallet = new Wallet;
        $wallet->member_id = auth()->user()->id;
        $wallet->username = auth()->user()->member_id;
        $wallet->net = ($request->amount - $charge_amount);
        $wallet->amount = $request->amount;
        $wallet->deduction = $charge_amount;
        $wallet->type = 'debit';
        $wallet->wallet_type = 1;
        $wallet->status = 0;
        $wallet->save();

        //update wallet balance
        $hirarchy = Hirarchy::where('member_id', auth()->user()->member_id)->first();
        $hirarchy->wallet_1 = $hirarchy->wallet_1 - $request->amount;
        $hirarchy->save();
    
        return response()->json(['status' => true, 'message' => 'Withdrawal Request of '.env('CURRENCY_SYMBOL').$request->amount.' Successfully Submitted']);
    }

}
