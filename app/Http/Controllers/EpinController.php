<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Epin;
use App\Models\Package;
use App\Http\Requests\Admin\Epins\CreateEpin;
use DataTables, DB;

class EpinController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::where('status', 1)->orderBy('amount', 'asc')->get();
        return view('admin.pages.epins.create', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEpin $request)
    {

        $package = Package::find($request->package_id);
        $quantity = $request->quantity;

        for ($i = 0; $i < $quantity; $i++) {
            $epin = Epin::create([
                'package_id'    => $request->package_id,
                'generated_by'  => auth()->user()->id,
                'issued_to'     => $request->member_id,
                'amount'        => $package->amount,
                'epin_code'     => $this->generateEpinCode(),
            ]);
        }

        return response()->json(['success' => true, 'message' => $quantity.' Epin(s) generated successfully for '.$request->member_id.'.']);
        
    }


    /* Generate Epin Code */
    private function generateEpinCode()
    {
        $epin_prefix = env('EPIN_ID_PREFIX');
        $epin_code = $epin_prefix.generateRandomNumber(7);
        $epin_code_exists = Epin::where('epin_code', $epin_code)->exists();
        if ($epin_code_exists) {
            return $this->generateEpinCode();
        } else {
            return $epin_code;
        }
    }


    // function to show list of epins with status 0
    public function available()
    {
        return view('admin.pages.epins.available');
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
            ->where('status', 0)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function($query){ 
                    $checkbox = '
                    <label class="ckbox">
                        <input type="checkbox" name="pin_id[]" class="pin_id" value="'.$query->id.'"">
                        <span></span>
                    </label>';
                    return $checkbox;
                })
                ->addColumn('createdDate', function($query){ 
                    $date = $query->created_at->format('d-M-Y h:i A');
                    return $date;
                })
                ->rawColumns(['checkbox', 'createdDate'])
                ->make(true);
        }
    }


    // function to show list of epins with status 1
    public function used()
    {
        return view('admin.pages.epins.used');
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
            ->where('status', 1)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    // function to history list of epins group by user
    public function history()
    {
        return view('admin.pages.epins.history');
    }

    /**
     * Show the list of epin create history
     *
     */
    public function historyList(Request $request){
        if ($request->ajax()) {

            DB::statement("SET SQL_MODE=''"); // disable strict mode in sql

            $data = Epin::select('id', 'issued_to', 'amount', 'generated_by', 'created_at', DB::raw('count(*) as quantity'))
            ->with(['user' => function($q){
                $q->select('id', 'name');
            }])
            ->groupBy('issued_to')
            ->groupBy('created_at')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->selected_pins;
        $epins = Epin::find($ids);

        foreach ($epins as $epin) {
            $epin->delete();
        }

        return response()->json(['success' => true, 'message' => count($ids).' Epin(s) deleted successfully.']);

    }
}
