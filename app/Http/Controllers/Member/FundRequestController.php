<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Member\FundRequest\NewRequest;
use App\Models\FundRequest;
use Intervention\Image\Facades\Image;
use DataTables;

class FundRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:member');
    }

    public function index()
    {
        return view('members.pages.fund-request.report');
    }

    public function newRequest()
    {
        return view('members.pages.fund-request.new');
    }

    public function requestList(Request $request)
    {
        if ($request->ajax()) {

            $data = FundRequest::select('id', 'member_id', 'transaction_id', 'amount', 'status', 'remarks', 'created_at')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->where('member_id', auth()->user()->member_id)
            ->orderBy('created_at', 'desc')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function($query){ 
                    $date = date('d-m-Y h:i A', strtotime($query->created_at));
                    return $date;
                })
                ->addColumn('request_status', function($query){
                    
                    if($query->status == 0){
                        $button = '<span class="badge badge-warning">Pending</span>';
                    }elseif($query->status == 1){
                        $button = '<span class="badge badge-success">Approved</span>';
                    }else{
                        $button = '<span class="badge badge-danger">Rejected</span>';
                    }

                    return $button;
                })
                ->rawColumns(['date', 'request_status'])
                ->make(true);
        }
    }

    public function store(NewRequest $request)
    {
        $validated = $request->validated();

        $file = $request->file('receipt');
        $receiptImage = $file->getRealPath(); //get the path of image
        $imageExt = $file->getClientOriginalExtension(); // file extension
        $receiptImageToSave = time().'.'.$imageExt; // rename image

        $img = Image::make($receiptImage);
        $img->save(public_path('uploads/fund-requests/').$receiptImageToSave, 40);

        $fundRequest                    = new FundRequest();
        $fundRequest->member_id         = auth()->user()->member_id;
        $fundRequest->amount            = $validated['amount'];
        $fundRequest->transaction_id    = $validated['transaction_id'];
        $fundRequest->receipt           = $receiptImageToSave;
        $fundRequest->save();

        return response()->json(['status' => true, 'message' => 'Fund request has been submitted successfully']);
    }
}
