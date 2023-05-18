<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hirarchy;
use App\Models\DownlineMember;
use DataTables;

class NetworkController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth:member');
    }

    public function referrals(){
    	return view('members.pages.network.referrals');
    }

    public function referralsReportList(Request $request)
    {
        if ($request->ajax()) {

            $sdate = $request->sdate;
            $edate = $request->edate;
            $username = auth()->user()->member_id;
            $type = $request->type;

            $data = Hirarchy::select('id', 'member_id', 'sponsor_id', 'activation_amount', 'activation_time', 'created_at')
            ->with(['member' => function($query){
                $query->select('id', 'member_id', 'full_name');
            }])
            ->filterDate($sdate, $edate)
            ->filterType($type)
            ->where('sponsor_id', $username)
            ->orderBy('created_at', 'desc')
            ->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('joinDate', function($query){ 
                    $date = date('d-m-Y h:i A', strtotime($query->created_at));
                    return $date;
                })
                ->addColumn('status', function($query){ 
                    if($query->activation_amount > 0){
                        $status = '<span class="badge badge-success">Active</span>';
                    }else{
                        $status = '<span class="badge badge-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('activationDate', function($query){
                    if($query->activation_amount > 0){
                        $date = date('d-m-Y h:i A', strtotime($query->activation_time));
                        return $date;
                    }else{
                        return '-';
                    }
                })
                ->addColumn('activationAmount', function($query){
                    if($query->activation_amount > 0){
                        return $query->activation_amount;
                    }else{
                        return '-';
                    }
                })
                ->rawColumns(['joinDate', 'status', 'activationDate', 'activationAmount'])
                ->make(true);
        }
    }

    public function downlineTeam ()
    {
        return view('members.pages.network.downline');
    }

    public function downlineTeamReportList(Request $request)
    {
        if ($request->ajax()) {

            $sdate = $request->sdate;
            $edate = $request->edate;
            $username = $request->username ? $request->username : auth()->user()->member_id;
            $type = $request->type;

            //init variable
            $checkValidity = true;

            if($username !== auth()->user()->member_id){
                //check if its valid downline
                $checkValidity = DownlineMember::where('member_id', auth()->user()->member_id)->where('location_id', $username)->exists();
            }

            if(!$checkValidity){
                $data = [];
            }else{
                $data = DownlineMember::select('id', 'member_id', 'location_id', 'level', 'created_at')
                ->with(['hirarchy' => function($query){
                    $query->select('id', 'member_id', 'sponsor_id', 'activation_amount', 'activation_time', 'created_at')
                    ->with(['member' => function($query){
                        $query->select('id', 'member_id', 'full_name');
                    }]);
                }])
                ->whereHas('hirarchy', function($query) use ($type){
                    $query->filterType($type);
                })
                ->filterDate($sdate, $edate)
                ->where('member_id', $username)
                ->orderBy('created_at', 'desc')
                ->get();
            }
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('joinDate', function($query){ 
                    $date = date('d-m-Y h:i A', strtotime($query->created_at));
                    return $date;
                })
                ->addColumn('status', function($query){ 
                    if($query->hirarchy->activation_amount > 0){
                        $status = '<span class="badge badge-success">Active</span>';
                    }else{
                        $status = '<span class="badge badge-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('activationDate', function($query){
                    if($query->hirarchy->activation_amount > 0){
                        $date = date('d-m-Y h:i A', strtotime($query->hirarchy->activation_time));
                        return $date;
                    }else{
                        return '-';
                    }
                })
                ->addColumn('activationAmount', function($query){
                    if($query->hirarchy->activation_amount > 0){
                        return $query->hirarchy->activation_amount;
                    }else{
                        return '-';
                    }
                })
                ->rawColumns(['joinDate', 'status', 'activationDate', 'activationAmount'])
                ->make(true);
        }
    }
}
