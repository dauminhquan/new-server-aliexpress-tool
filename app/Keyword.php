<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $fillable = ["keyword"];

    public function server(){
        return $this->belongsTo(Server::class);
    }
}
