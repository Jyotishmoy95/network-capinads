<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Ads\CreateAd;
use App\Http\Requests\Admin\Ads\UpdateAd;
use Intervention\Image\Facades\Image;
use App\Models\Ad;
use DataTables;

class AdController extends Controller
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
        return view('admin.pages.ads.index');
    }


    /**
     * Show the list of ads created
     *
     */
    public function allAds(Request $request){
        if ($request->ajax()) {
            $data = Ad::select('id', 'title', 'ad_type', 'status', 'created_at')->orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a data-id="'.$row->id.'" href="'.asset('admin/ad-details/edit/'.$row->id).'" class="btn btn-sm btn-info toggle-status">
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
        return view('admin.pages.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAd $request)
    {   
        $youtube_video_id = null;
        $imageNameToSave = null;

        if($request->ad_type == 'url'){
            $isYoutube = isYoutubeUrl($request->ad_url);
            
            if($isYoutube){
                $youtube_video_id = getYoutubeVideoId($request->ad_url);
            }
        }else{
            $file = $request->file('ad_image');
            $adImage = $file->getRealPath(); //get the path of image
            $imageExt = $file->getClientOriginalExtension(); // file extension
            $imageNameToSave = time().'.'.$imageExt; // rename image

            $img = Image::make($adImage);
            $img->save(public_path('uploads/ads/').$imageNameToSave, 40);
        }

        $ad             = new Ad;
        $ad->title      = $request->ad_title;
        $ad->url        = $request->ad_url;
        $ad->ad_type    = $request->ad_type;
        $ad->youtube_id = $youtube_video_id;
        $ad->image      = $imageNameToSave;
        $ad->save();

        return response()->json([
            'success' => true,
            'message' => 'Ad created successfully.'
        ]);

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
        $ad = Ad::find($id);
        return view('admin.pages.ads.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAd $request, $id)
    {
        $youtube_video_id = null;
        $imageNameToSave = null;

        $ad = Ad::find($id);

        if($request->ad_type == 'url'){
            $isYoutube = isYoutubeUrl($request->ad_url);
            
            if($isYoutube){
                $youtube_video_id = getYoutubeVideoId($request->ad_url);
            }
        }else{
            if($request->hasFile('ad_image')){
                $file = $request->file('ad_image');
                $adImage = $file->getRealPath(); //get the path of image
                $imageExt = $file->getClientOriginalExtension(); // file extension
                $imageNameToSave = time().'.'.$imageExt; // rename image

                $img = Image::make($adImage);
                $img->save(public_path('uploads/ads/').$imageNameToSave, 40);

                // delete old image
                if($ad->image){
                    $oldImage = public_path('uploads/ads/').$ad->image;
                    if(file_exists($oldImage)){
                        unlink($oldImage);
                    }
                }

            }else{
                $imageNameToSave = $ad->image;
            }
        }

        $ad->title      = $request->ad_title;
        $ad->url        = $request->ad_url;
        $ad->ad_type    = $request->ad_type;
        $ad->youtube_id = $youtube_video_id;
        $ad->image      = $imageNameToSave;
        $ad->save();

        return response()->json([
            'success' => true,
            'message' => 'Ad updated successfully.'
        ]);
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

    // toggle status of a ad
    public function updateStatus(Request $request){
        $package = Ad::find($request->id);
        if($package->status == 1){
            $package->status = 0;
        }else{
            $package->status = 1;
        }
        $package->save();
        return response()->json(['success' => true, 'message' => 'Ad status successfully updated.']);
    }


}
