<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FundRequest;
use App\Models\Hirarchy;
use App\Http\Requests\Admin\FundRequest\Action;
use DataTables;

class FundRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function pending()
    {
        return view('admin.pages.fund-requests.pending');
    }

    public function rejected()
    {
        return view('admin.pages.fund-requests.rejected');
    }

    public function approved()
    {
        return view('admin.pages.fund-requests.approved');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {

            $status = $request->status;

            $data = FundRequest::select('id', 'member_id', 'transaction_id', 'amount', 'status', 'remarks', 'receipt', 'created_at')
            ->filterStatus($status)
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
                ->addColumn('receipt', function($query){
                    //receipt image download button
                    return '<a href="'.asset('uploads/fund-requests/'.$query->receipt).'" download class="btn btn-sm btn-info">Download</a>';
                })
                ->addColumn('action', function($query){
                    if($query->status == 0){
                        $button = '<button class="btn btn-sm btn-success fund-request-action" data-action="approve" data-id="'.$query->id.'">Approve</button>&emsp;';
                        $button.=  '<button class="btn btn-sm btn-danger fund-request-action" data-action="reject" data-id="'.$query->id.'">Reject</button>';
                        return $button;
                    }
                })
                ->rawColumns(['date', 'receipt', 'action'])
                ->make(true);
        }
    }

    public function action(Action $request)
    {
        $validated = $request->validated();

        $fund_request = FundRequest::findOrFail($validated['id']);

        $hirarchy = Hirarchy::where('member_id', $fund_request->member_id)->first();

        if($validated['action'] == 'approve'){
            $fund_request->status = 1;
            $message = 'Fund Request Approved';

            //update wallet
            $hirarchy->wallet_3 = $hirarchy->wallet_3 + $fund_request->amount;
            $hirarchy->save();
        }else{
            $fund_request->status = 2;
            $message = 'Fund Request Rejected';
        }

        $fund_request->remarks = $validated['remark'];
        $fund_request->save();

        return response()->json(['status' => true, 'message' => $message]);

    }

}
