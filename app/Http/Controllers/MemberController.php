<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Hirarchy;
use DataTables;

class MemberController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web')->except('checkMember');
    }

    // All members list view
    public function index()
    {
        return view('admin.pages.members.index');
    }

    public function show($id)
    {
        $member = Member::find($id);
        return view('admin.pages.members.show', compact('member'));
    }

    // Get all members list
    public function allMembers(Request $request){
        if ($request->ajax()) {
            $data = Hirarchy::select('member_id', 'sponsor_id', 'activation_amount', 'created_at')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name')->with('documents');
            }])
            ->orderBy('created_at', 'desc')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.asset('admin/members/'.$row->member->id).'" class="btn btn-primary btn-sm">Edit Profile</a>';
                })
                ->addColumn('join_date', function($row){
                    return date('Y-m-d h:i A', strtotime($row->created_at));
                })
                ->addColumn('documents', function($row){
                    if($row->member->documents && $row->member->documents->document_photo){
                        return '<a href="'.asset('uploads/documents/'.$row->member->documents->document_photo).'" target="_blank" class="btn btn-primary btn-sm">View Document</a>';
                    }else{
                        return 'N/A';
                    }
                })
                ->rawColumns(['action', 'join_date', 'documents'])
                ->make(true);
        }
    }

    // Working members list view
    public function working()
    {
        return view('admin.pages.members.working');
    }

    // Get working members list
    public function allWorking(Request $request){
        if ($request->ajax()) {
            $data = Hirarchy::select('member_id', 'sponsor_id', 'activation_amount', 'created_at', 'activation_time')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->where('activation_amount', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    // Non working members list view
    public function nonWorking()
    {
        return view('admin.pages.members.non-working');
    }

    // Get non-working members list
    public function allNonWorking(Request $request){
        if ($request->ajax()) {
            $data = Hirarchy::select('member_id', 'sponsor_id', 'activation_amount', 'created_at', 'activation_time')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->where('activation_amount', 0)
            ->orderBy('created_at', 'desc')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }


    // function to check if a member exists
    public function checkMember(Request $request)
    {
        $member = Member::where('member_id', $request->member_id)->with(['hirarchy' => function($query){
            $query->select('id', 'member_id', 'activation_amount', 'wallet_1', 'wallet_3');
        }])->first();
        if ($member) {
            return response()->json(['status' => true, 'member' => $member]);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid Username']);
        }
    }
}
