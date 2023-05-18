<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Packages\CreatePackage;
use App\Http\Requests\Admin\Packages\UpdatePackage;
use App\Models\Package;
use App\Models\PackageLevel;
use App\Models\AdLevelIncome;
use DataTables;

class PackageController extends Controller
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
        return view('admin.pages.packages.index');
    }
    
    /**
     * Show the list of packages created
     *
     */
    public function list(Request $request){
        if ($request->ajax()) {
            $data = Package::select('id', 'package_name', 'amount', 'status', 'created_at')->orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a data-id="'.$row->id.'" href="'.asset('admin/packages/edit/'.$row->id).'" class="btn btn-sm btn-info toggle-status">
                        <i class="fe fe-edit-2"></i>
                    </a>';
                    return $actionBtn;
                })
                ->addColumn('toggle', function($row){
                    $featured = '';
                    $fText = 'Inactive';

                    $toggleBtn = '';

                    if($row->status == 1){
                        $featured = 'checked';
                        $fText = 'Active';
                    }

                    //if(auth()->user()->can('Edit Test')){
                        $toggleBtn.= 
                            '<label class="custom-switch">
                                <input type="checkbox" data-id="'.$row->id.'" name="custom-switch-checkbox" class="toggle-status custom-switch-input" '.$featured.'>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">'.$fText.'</span>
                            </label>';
                    //}
                    return $toggleBtn;
                })
                ->rawColumns(['action', 'toggle'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = env('INCOME_LEVELS');
        $ad_levels = env('AD_LEVELS');
        return view('admin.pages.packages.create', compact('levels',  'ad_levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePackage $request)
    {
        $package = Package::create([
            'package_name'      => $request->package_name,
            'amount'            => $request->amount,
            'self_ad_income'    => $request->self_ad_income,
            'level_type'        => $request->level_type
        ]);  
        
        foreach ($request->levels as $key => $value) {
            $package->levels()->create([
                'package_id'        => $package->id,
                'amount'            => $request->levels[$key],
                'level'             => $key+1,
                'direct_referrals'  => $request->referrals[$key],
            ]);
        }

        foreach($request->ad_levels as $key => $value){
            $package->adViewLevels()->create([
                'package_id'        => $package->id,
                'amount'            => $request->ad_levels[$key],
                'level'             => $key+1
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Package created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::with('levels')->with('adViewLevels')->find($id);
        $levels = env('INCOME_LEVELS');
        $ad_levels = env('AD_LEVELS');
        return view('admin.pages.packages.edit', compact('package', 'levels', 'ad_levels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackage $request, $id)
    {
        $package = Package::where('id', $id)->update([
            'package_name'      => $request->package_name,
            'amount'            => $request->amount,
            'self_ad_income'    => $request->self_ad_income,
            'level_type'        => $request->level_type
        ]);  
        
        PackageLevel::where('package_id', $id)->delete(); // Delete old package levels data

        foreach ($request->levels as $key => $value) {
            PackageLevel::create([
                'package_id'        => $id,
                'amount'            => $request->levels[$key],
                'level'             => $key+1,
                'direct_referrals'  => $request->referrals[$key],
            ]);
        }

        AdLevelIncome::where('package_id', $id)->delete(); // Delete old ad levels data

        foreach($request->ad_levels as $key => $value){
            AdLevelIncome::create([
                'package_id'        => $id,
                'amount'            => $request->ad_levels[$key],
                'level'             => $key+1
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Package successfully updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // toggle status of a package
    public function updateStatus(Request $request){
        $package = Package::find($request->id);
        if($package->status == 1){
            $package->status = 0;
        }else{
            $package->status = 1;
        }
        $package->save();
        return response()->json(['success' => true, 'message' => 'Package status updated successfully.']);
    }

    
}
