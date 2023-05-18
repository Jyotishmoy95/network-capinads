<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Member;
use App\Models\Hirarchy;
use App\Models\FundTransfer;
use App\Http\Requests\Admin\FundTransfer\NewTransfer;
use DataTables;

class FundTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index()
    {
        return view('admin.pages.fund-transfer.report');
    }

    public function newTransfer()
    {
        return view('admin.pages.fund-transfer.new');
    }

    public function transferList(Request $request)
    {
        if ($request->ajax()) {

            $sdate = $request->sdate;
            $edate = $request->edate;
            $username = $request->username;

            $data = FundTransfer::select('id', 'member_id', 'net', 'amount', 'deduction', 'remarks', 'created_at')
            ->filterDate($sdate, $edate)
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->filterUsername($username)
            ->orderBy('created_at', 'desc')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function($query){ 
                    $date = date('d-m-Y h:i A', strtotime($query->created_at));
                    return $date;
                })
                ->rawColumns(['date'])
                ->make(true);
        }
    }

    public function transfer(NewTransfer $request)
    {
        $income_name = json_decode(env('INCOME_TYPES'), true);
        $validated = $request->validated();

        $member = Member::where('member_id', $validated['member_id'])->first();

        $fund_transfer = new FundTransfer;
        $fund_transfer->member_id = $member->member_id;
        $fund_transfer->transfered_by = 'Admin';
        $fund_transfer->amount = $validated['amount'];
        $fund_transfer->net = $validated['amount'];
        $fund_transfer->sender_wallet_type = 0;
        $fund_transfer->receiver_wallet_type = 3;
        $fund_transfer->remarks = $income_name['3'];
        $fund_transfer->save();

        //update wallet balance
        $hirarchy = Hirarchy::where('member_id', $validated['member_id'])->first();
        $hirarchy->wallet_3 = $hirarchy->wallet_3 + $validated['amount'];
        $hirarchy->save();
    
        return response()->json(['status' => true, 'message' => 'Fund Transfer of '.env('CURRENCY_SYMBOL').$validated['amount'].' to '.$validated['member_id'].' is successfully completed']);
    }
}
