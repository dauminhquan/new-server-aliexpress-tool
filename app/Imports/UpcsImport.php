<?php

namespace App\Imports;

use App\Upc;
use Maatwebsite\Excel\Concerns\ToModel;

class UpcsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Upc([
            "key" => $row[0]
        ]);
    }
}
