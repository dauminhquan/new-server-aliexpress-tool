<?php

namespace App\Http\Controllers;

use App\Product;
use App\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TemplateProductController extends Controller
{

    public function index(Request $request,$id)
    {
        $template = Template::findOrFail($id);
        $default = ['item_name', 'item_sku', 'main_image_url'];
        if ($request->column_selected != null)
        {
            $default  = $request->column_selected;
        }
        $columns = Schema::getColumnListing($template->table_name);
        $products = DB::table($template->table_name);
        if($request->search != null)
        {
            foreach ($columns as $column)
            {
                $products->orWhere(DB::raw('LOWER('.$column.')'),'LIKE','%'.strtolower($request->search).'%');
            }
        }
        if($request->exported != null)
        {
            if($request->exported == "on")
            {

                $products->where('exported',"=",true);

            }else if($request->exported == "off"){
                $products->where('exported',"=",false);
            }
        }
        $products->select($default);
        if($request->limit == null)
        {
            $products = $products->paginate(20);
        }
        else{
            $products = $products->paginate($request->limit);
        }
        return view('template-products',['products' => $products,'columns' => $columns,'column_selected' => $default,'request' => $request]);
    }


    public function actions(Request $request,$id)
    {

        switch ($request->action){
            case "add_product": {
                return response()->redirectToRoute('template-products.add_product',['id' => $id]);
            }
        }
    }

    public function add_product(Request $request,$id){
        $template = Template::findOrFail($id);
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
        return view('template-products-add',['products' => $products,'columns' => $columns,'column_selected' => $default,'request' => $request]);
    }
    public function post_add_product(Request $request,$id)
    {
        $template = Template::findOrFail($id);
        $sorts = explode(';',$template->sort);
//        $inserts = DB::table($template->table_name);
        $ids = $request->id_selected;

        $products = DB::table('products');
        $products->where(function($query) use ($ids){
            foreach ($ids as $item)
            {
                $query->orWhere("id","=",$item);
            }
        });
        $products = $products->get();

        foreach ($products as $product)
        {

            $item = [];
            foreach ($sorts as $sort)
            {
                if(isset($product->$sort))
                {
                    $item[$sort] = $product->$sort;
                }
            }
            DB::table($template->table_name)->insert($item);
            $products->delete();
        }

//        DB::table($template->table_name)->insert($inserts);
        return back()->withErrors(["Thêm vào thành công"]);
    }
}
