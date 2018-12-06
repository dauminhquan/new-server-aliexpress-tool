<?php

namespace App\Http\Controllers;

use App\Keyword;
use App\Product;
use App\Server;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KeywordsImport;
class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $servers = Server::get();
        $columns = Schema::getColumnListing('keywords');
        $keywords = DB::table('keywords');
        if($request->search != null)
        {
            foreach ($columns as $column)
            {
                $keywords->orWhere(DB::raw('LOWER('.$column.')'),'LIKE','%'.strtolower($request->search).'%');
            }
        }
        $keywords->orderBy('id','asc');
        if($request->limit == null)
        {
            $keywords = $keywords->paginate(20);
        }
        else{
            $keywords = $keywords->paginate($request->limit);
        }
        foreach ($keywords as $keyword)
        {
            if($keyword->server_id != null)
            {
                $keyword->server = Server::find($keyword->server_id);
            }
        }
        return view('keywords',['keywords' => $keywords,'columns' => $columns,'request' => $request,'servers' => $servers]);
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
        if($request->hasFile('file'))
        {
            Excel::import(new KeywordsImport(), $request->file('file'));
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
        if($request->action == "search")
        {
            $keyword = Keyword::findOrFail($id);
            $keyword->server_id = $request->server_id;
            $keyword->multiplication = $request->multiplication;
            $keyword->status = 1;
            $server = Server::findOrFail($request->server_id);
            $client = new Client();
            try{
                $res = $client->request('GET', $server->root_url.'/search?query='.$keyword->keyword.'&page='.$keyword->page.'&multiplication='.$request->multiplication
                .'&keyword_id='.$keyword->id.'&start=1&token=8ifOh3JKYCNg01I2K0PI'

                );
            }catch (\Exception $exception)
            {
                return response()->json([
                    "message" => "cannot connect to server"
                ],404);
            }
            if($res->getStatusCode() != 200)
            {
                return response()->json([
                    "message" => "cannot connect to server"
                ],404);
            }
            $keyword->save();
        }
        if($request->action == "stop")
        {
            $keyword = Keyword::findOrFail($id);
            $server = Server::findOrFail($keyword->server_id);
            $keyword = Keyword::findOrFail($id);
            $client = new Client();

            try{
                $res = $client->request('GET', $server->root_url.'/stop-search?keyword_id='.$keyword->id.'&token=vmWRXUKQA6xZZYTCdXsY');
            }catch (\Exception $exception)
            {
                return response()->json([
                    "message" => "cannot connect to server"
                ],404);
            }
            if($res->getStatusCode() != 200)
            {
                return response()->json([
                    "message" => "cannot connect to server"
                ],404);
            }
            $keyword->status = 2;
            $keyword->save();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $keyword = Keyword::findOrFail($id);
        $keyword->delete();
        if($request->has('delete_all'))
        {
            Product::where('keyword_id','=',$keyword->id)->delete();
        }
        return back();

    }

    public function done(Request $request,$id)
    {
        if($request->token == "n10JJg7XfBc4XWdbt9lw")
        {
            $keyword = Keyword::findOrFail($id);
            $keyword->status = 3;
            $keyword->save();
        }

        return response([
            'message' => 'success'
        ]);
    }
    public function page(Request $request,$id,$page)
    {
        if($request->token == "n10JJg7XfBc4XWdbt9lw")
        {
            $keyword = Keyword::findOrFail($id);
            $keyword->page = $page;
            $keyword->save();
        }
        return response([
            'message' => 'success'
        ]);
    }
}
