<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Incentive;
use DataTables;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:member');
    }

    public function walletReport()
    {
        return view('members.pages.reports.wallet');
    }

    public function walletReportList(Request $request)
    {
        if ($request->ajax()) {
            $data = Wallet::select('id', 'member_id', 'username', 'net', 'type', 'remark', 'created_at')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->where('username', auth()->user()->member_id)
            ->orderBy('created_at', 'desc')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function($query){ 
                    $date = date('d-m-Y h:i A', strtotime($query->created_at));
                    return $date;
                })
                ->addColumn('transaction', function($query){ 
                    $transaction = $query->type;

                    if($transaction == 'credit'){
                        $transaction = '<span class="badge badge-success">Credit</span>';
                    }elseif($transaction == 'debit'){
                        $transaction = '<span class="badge badge-danger">Debit</span>';
                    }

                    return $transaction;
                })
                ->rawColumns(['date', 'transaction'])
                ->make(true);
        }
    }

    public function incentivesReport()
    {
        $income_types = json_decode(env('INCOME_TYPES'), true);
        $types_of_income = [$income_types['1'], $income_types['2'], $income_types['5']];
        return view('members.pages.reports.incentives', compact('types_of_income'));
    }

    public function incentivesReportList(Request $request)
    {

        $sdate = $request->sdate;
        $edate = $request->edate;
        $username = auth()->user()->member_id;
        $type = $request->type;

        if ($request->ajax()) {
            $data = Incentive::select('id', 'member_id', 'username', 'net', 'incentive_name', 'incentive_for', 'incentive_info', 'created_at')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->filterType($type)
            ->filterDate($sdate, $edate)
            ->filterUsername($username)
            ->orderBy('created_at', 'desc')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function($query){ 
                    $date = date('d-m-Y h:i A', strtotime($query->created_at));
                    return $date;
                })
                ->addColumn('info', function($query){ 
                    if($query->incentive_for == 'ad_view'){
                        $info = 'Viewing Ads';
                    }else{
                        $info = 'Username: '.$query->incentive_for.'<br> Level: '.$query->incentive_info;
                    }
                    return $info;
                })
                ->rawColumns(['date', 'info'])
                ->make(true);
        }
    }

}
