<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Requests\Admin\News\CreateNews;
use DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.news.index');
    }

    public function list(Request $request){
        if ($request->ajax()) {
            $data = News::select('id', 'title', 'status', 'created_at')->orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a data-id="'.$row->id.'" href="'.asset('admin/news/edit/'.$row->id).'" class="btn btn-sm btn-info toggle-status">
                        <i class="fe fe-edit-2"></i>
                    </a>';
                    $actionBtn.= '&emsp;<a data-id="'.$row->id.'" href="#" class="btn btn-sm btn-danger delete-news">
                        <i class="fe fe-trash-2"></i>
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
        return view('admin.pages.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNews $request)
    {
        $validated = $request->validated();

        $news = new News;
        $news->title = $validated['news_title'];
        $news->content = $validated['news_content'];
        $news->save();

        return response()->json(['status' => true, 'message' => 'News created successfully']);
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
        $news = News::findOrFail($id);
        return view('admin.pages.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateNews $request, $id)
    {
        $validated = $request->validated();

        $news = News::findOrFail($id);
        $news->title = $validated['news_title'];
        $news->content = $validated['news_content'];
        $news->save();

        return response()->json(['status' => true, 'message' => 'News updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $news = News::findOrFail($id);
        $news->delete();

        return response()->json(['status' => true, 'message' => 'News deleted successfully']);
    }

    // toggle status of a news
    public function updateStatus(Request $request){
        $news = News::find($request->id);
        if($news->status == 1){
            $news->status = 0;
        }else{
            $news->status = 1;
        }
        $news->save();
        return response()->json(['success' => true, 'message' => 'News status updated successfully.']);
    }
}
