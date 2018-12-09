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
        $upc = Upc::where('key','=',$row[0])->first();
        if($upc == null)
        {
            return new Upc([
                "key" => $row[0]
            ]);
        }
        return null;
    }
}
