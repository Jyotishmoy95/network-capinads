<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Hirarchy;
use App\Models\Incentive;
use DataTables;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function accountReport()
    {
        return view('admin.pages.reports.account');
    }

    public function accountReportList(Request $request)
    {
        if ($request->ajax()) {
            $data = Wallet::select('id', 'member_id', 'username', 'net', 'type', 'remark', 'created_at')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
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

    public function earningsReport()
    {
        return view('admin.pages.reports.earnings');
    }

    public function earningsReportList(Request $request)
    {
        if ($request->ajax()) {
            $data = Hirarchy::select('id', 'member_id', 'total_income')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->orderBy('created_at', 'asc')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function walletReport()
    {
        return view('admin.pages.reports.wallet');
    }

    public function walletReportList(Request $request)
    {
        if ($request->ajax()) {
            $data = Hirarchy::select('id', 'member_id', 'wallet_1')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->orderBy('created_at', 'asc')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function incentivesReport()
    {
        $income_types = json_decode(env('INCOME_TYPES'), true);
        $types_of_income = [$income_types['1'], $income_types['2'], $income_types['5']];
        return view('admin.pages.reports.incentives', compact('types_of_income'));
    }

    public function incentivesReportList(Request $request)
    {

        $sdate = $request->sdate;
        $edate = $request->edate;
        $username = $request->username;
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

    public function withdrawalReport()
    {
        return view('admin.pages.reports.withdrawals');
    }

    public function withdrawalReportList(Request $request)
    {
        if ($request->ajax()) {

            $sdate = $request->sdate;
            $edate = $request->edate;
            $username = $request->username;
            $status = $request->status;

            $data = Wallet::select('id', 'member_id', 'username', 'net', 'type', 'remark', 'created_at')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->with('bankDetails')
            ->filterDate($sdate, $edate)
            ->filterStatus($status)
            ->filterUsername($username)
            ->where('type', 'debit')
            ->orderBy('created_at', 'desc')
            ->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function($query){ 
                    $date = date('d-m-Y h:i A', strtotime($query->created_at));
                    return $date;
                })
                ->addColumn('status', function($query){ 
                    if($query->status == 0){
                        $status = '<span class="badge badge-dark">Pending</span>';
                    }elseif($query->status == 1){
                        $status = '<span class="badge badge-success">Paid</span>';
                    }elseif($query->status == 2){
                        $status = '<span class="badge badge-danger">Rejected</span>';
                    }
                    return $status;
                })
                ->addColumn('bankDetails', function($query){ 
                    $bank_details = 'Bank Name: '.$query->bankDetails->bank_name.'<br>'.
                                    'A/C Name: '.$query->bankDetails->account_name.'<br>'.
                                    'A/C No: '.$query->bankDetails->account_number.'<br>'.
                                    'IFSC: '.$query->bankDetails->ifsc_code;
                    return $bank_details;
                })
                ->rawColumns(['date', 'status', 'bankDetails'])
                ->make(true);
        }
    }

}
