<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Epin;
use DataTables, DB;

class EpinController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:member');
    }

    public function availableEpins()
    {
        return view('members.pages.epins.available');
    }

    /**
     * Show the list of available epins
     *
     */
    public function availableList(Request $request){
        if ($request->ajax()) {
            $data = Epin::select('id', 'epin_code', 'issued_to', 'amount', 'generated_by', 'created_at')
            ->with(['user' => function($q){
                $q->select('id', 'name');
            }])
            ->where('issued_to', auth()->user()->member_id)
            ->where('status', 0)
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('createdDate', function($query){ 
                    $date = \Carbon\Carbon::parse($query->created_at)->format('d-m-Y h:i A');
                    return $date;
                })
                ->rawColumns(['createdDate'])
                ->make(true);
        }
    }


    // function to show list of epins with status 1
    public function used()
    {
        return view('members.pages.epins.used');
    }

    /**
     * Show the list of used epins
     *
     */
    public function usedList(Request $request){
        if ($request->ajax()) {
            $data = Epin::select('id', 'epin_code', 'issued_to', 'amount', 'used_by', 'generated_by', 'created_at')
            ->with(['user' => function($q){
                $q->select('id', 'name');
            }])
            ->where('issued_to', auth()->user()->member_id)
            ->where('status', 1)
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '';
                    return $actionBtn;
                })
                ->addColumn('createdDate', function($query){ 
                    $date = \Carbon\Carbon::parse($query->created_at)->format('d-m-Y h:i A');
                    return $date;
                })
                ->rawColumns(['action', 'createdDate'])
                ->make(true);
        }
    }

}
