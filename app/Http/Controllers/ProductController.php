<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $default = ['item_name', 'item_sku', 'main_image_url'];
        if ($request->column_selected != null)
        {
            $default  = $request->column_selected;
        }
        $columns = Schema::getColumnListing('products');
        $products = DB::table('products');
        if($request->search != null)
        {
            foreach ($columns as $column)
            {
                $products->orWhere(DB::raw('LOWER('.$column.')'),'LIKE','%'.strtolower($request->search).'%');
            }
        }
        if(!in_array('id',$default))
        {
            $default = array_merge(['id'],$default);
        }
        $products->select($default);
        $products->orderBy('id','asc');
        if($request->limit == null)
        {
            $products = $products->paginate(20);
        }
        else{
            $products = $products->paginate($request->limit);
        }
        return view('products',['products' => $products,'columns' => $columns,'column_selected' => $default,'request' => $request]);
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
        if($request->action == 'delete')
        {
            $this->delete_multiple_product($request->id_selected);
        }
        if($request->action == 'update')
        {
            return response()->redirectToRoute('update-info',["ids" => implode(",",$request->id_selected)]);
        }
        return back();
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
    public function destroy($id)
    {
        //
    }


    private function delete_multiple_product($ids)
    {

        if($ids != null)
        {
            if(count($ids) > 0)
            {
                foreach ($ids as $id)
                {
                    $product = Product::findOrFail($id);
                    $product->delete();
                }
            }
        }
    }
    public function update_multiple_product(Request $request)
    {
        if($request->ids != null)
        {
            $ids = $request->ids;
            $columns = Schema::getColumnListing('products');
            $column_selected = ["item_name"];
            if($request->column_selected != null)
            {
                $column_selected = $request->column_selected;
            }
            return view('update_info',["ids" => $ids,'columns' => $columns,'column_selected' => $column_selected]);
        }
        return back();
    }
    public function post_update_multiple_product(Request $request){

        if($request->ids != null)
        {
            $columns = Schema::getColumnListing('products');
            $profile = [];
            $profileRequest = $request->all();
            foreach ($profileRequest as $item)
            {
                if(in_array($item,$columns))
                {
                    $profile[] = $item;
                }
            }
            $ids = explode(",",$request->ids);
            foreach ($ids as $id)
            {
                $product = Product::findOrFail($id);
                foreach ($profile as $item)
                {
                    $profile->$item = $request->$item;
                }
                $product->save();
            }
            return back()->withErrors(['Thành công']);
        }
        return back();
    }
}