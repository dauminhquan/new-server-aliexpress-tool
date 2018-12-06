<?php

namespace App\Http\Controllers;

use App\Keyword;
use App\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = Schema::getColumnListing('servers');
        $servers = DB::table('servers');
        if($request->search != null)
        {
            foreach ($columns as $column)
            {
                $servers->orWhere(DB::raw('LOWER('.$column.')'),'LIKE','%'.strtolower($request->search).'%');
            }
        }
        $servers->orderBy('id','asc');
        if($request->limit == null)
        {
            $servers = $servers->paginate(20);
        }
        else{
            $servers = $servers->paginate($request->limit);
        }
        return view('servers',['servers' => $servers,'columns' => $columns,'request' => $request]);
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
        $server = new Server();
        $server->name = $request->name;
        $server->root_url = $request->root_url;
        $server->save();
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
        $server = Server::findOrFail($id);
        $server->delete();
        Keyword::where('server_id',"=",$server->id)->update([
           "server_id" => null,
           "status" => 3
        ]);
        return back();
    }

}
