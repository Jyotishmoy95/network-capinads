<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Download;
use App\Http\Requests\Admin\Downloads\CreateDownload;
use DataTables;

class DownloadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.downloads.index');
    }

    public function list(Request $request){
        if ($request->ajax()) {
            $data = Download::select('id', 'title', 'file', 'status', 'created_at')->orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('url', function($row){
                    return '<a href="'.asset('uploads/downloads/'.$row->file).'" class="btn btn-primary btn-sm" download>Download</a>';
                })
                ->addColumn('action', function($row){
                    // $actionBtn = '<a data-id="'.$row->id.'" href="'.asset('admin/downloads/edit/'.$row->id).'" class="btn btn-sm btn-info toggle-status">
                    //     <i class="fe fe-edit-2"></i>
                    // </a>';
                    $actionBtn = '&emsp;<a data-id="'.$row->id.'" href="#" class="btn btn-sm btn-danger delete-file">
                        <i class="fe fe-trash-2"></i>
                    </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'url'])
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
        return view('admin.pages.downloads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDownload $request)
    {
        $validated = $request->validated();

        //save uploaded file
        $file = $request->file('file');
        $adImage = $file->getRealPath(); //get the path of file
        $fileExt = $file->getClientOriginalExtension(); // file extension
        $fileNameToSave = time().'.'.$fileExt; // rename file 
        $path = public_path('uploads/downloads'); // path
        $file->move($path, $fileNameToSave); // upload file

        $news = new Download;
        $news->title = $validated['title'];
        $news->file = $fileNameToSave;
        $news->save();

        return response()->json(['status' => true, 'message' => 'Download created successfully']);
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
        $news = Download::findOrFail($id);
        return view('admin.pages.downloads.edit', compact('news'));
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

        $news = Download::findOrFail($id);
        $news->title = $validated['news_title'];
        $news->content = $validated['news_content'];
        $news->save();

        return response()->json(['status' => true, 'message' => 'Download updated successfully']);
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

        $news = Download::findOrFail($id);
        $news->delete();

        return response()->json(['status' => true, 'message' => 'Download deleted successfully']);
    }
}
