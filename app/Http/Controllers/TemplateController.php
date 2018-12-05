<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateRequest;
use App\Imports\TemplateImport;
use App\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = 20;
        if($request->has("limit"))
        {
            $limit = $request->limit;
        }
        $templates = DB::table('templates');
        if($request->search != null)
        {
            $templates->where('name','=',$request->search);
        }
        $templates = $templates->paginate($limit);
        return view('templates',["request" => $request ,"templates" => $templates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateRequest $request)
    {
        if(Schema::hasTable($request->table_name))
        {
            return back()->withErrors(["Bảng đã tồn tại"]);
        }
        $template = new Template();
        $template->name = $request->name;
        $template->table_name = $request->table_name;
        $template->file = $request->file('file')->store('templates');
        $template->save();
        Excel::import(new TemplateImport($request->table_name,$template->id), $request->file("file"));
        return response()->redirectToRoute('templates.index')->withErrors(["Thêm mới thành công"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $size = 30;
//        if($request->has('size'))
//        {
//            $size = $request->size;
//        }
//        $template = Template::findOrFail($id);
//        $products = DB::table($template->table_name)->paginate($size);
//        return view('template_products',['products' => $products]);
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
    public function destroy($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();
        Schema::dropIfExists($template->table_name);
        return response()->redirectToRoute('templates.index')->withErrors(['Xóa thành công']);
    }
}
