<?php

namespace App\Http\Controllers;

use App\Imports\TemplateImport;
use App\Template;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Excel::import(new TemplateImport(), 'BodyPaint.xlsm');
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
    public function store(Request $request)
    {


        Excel::import(new TemplateImport(), 'users.xlsx');

//        $template = new Template();
//        if(!$request->hasFile("excel-file"))
//        {
//            return response()->json(["err" => 1],403);
//        }
//        $url = $request->file("excel-file")->storeAs("templates",$request->name.".xlsx");
//        DB::transaction(function () use ($request,$url){
//            Excel::selectSheets("Template")->load($request->file("excel-file"), function($reader) use($request,$url){
//                $reader->setHeaderRow(3);
//                $first = $reader->first()->toArray();
//                $column_commons = [];
//                $columns = array_keys($first);
//                $listID = [];
//                foreach ($columns as $column)
//                {
//                    $tempColumn = Column::where('name',$column)->first();
//                    if($tempColumn == null)
//                    {
//                        $tableColumns = Schema::getColumnListing('products');
//                        $index = array_search ($column,$tableColumns);
//
//                        $temp = new Column();
//                        $temp->name = $column;
//                        if($index !==false)
//                        {
//                            $temp->product_column = $tableColumns[$index];
//                        }
//                        $temp->save();
//                        $listID[] = $temp->id;
//                        if($first[$column] != null)
//                        {
//                            $column_commons[] = [
//                                "id" => $temp->id,
//                                "value" => $first[$column]
//                            ];
//                        }
//                    }
//                    else{
//                        $listID[] = $tempColumn->id;
//                        if($first[$column] != null)
//                        {
//                            $column_commons[] = [
//                                "id" => $tempColumn->id,
//                                "value" => $first[$column]
//                            ];
//                        }
//                    }
//                }
//                $template = new Template();
//                $template->name = $request->name;
//                $template->sort = implode(";",$columns);
//                $template->file = $url;
//                $template->user_id = Auth::user()->id;
//                $template->save();
//                $insert = [];
//                $insertColumn_common = [];
//                foreach ($column_commons as $item)
//                {
//                    $insertColumn_common[] = [
//                        "template_id" =>  $template->id,
//                        "column_id" => $item["id"],
//                        "value" => $item["value"],
//                        "created_at" => Carbon::now()
//                    ];
//                }
//                foreach ($listID as $item)
//                {
//                    $insert[] = [
//                        "template_id" =>  $template->id,
//                        "column_id" => $item,
//                        "created_at" => Carbon::now()
//                    ];
//                }
//                DB::table("common_columns")->insert($insertColumn_common);
//                DB::table("template_columns")->insert($insert);
//            });
//        });
//        return $template;
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
        //
    }
}
