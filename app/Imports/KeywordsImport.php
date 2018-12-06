<?php

namespace App\Imports;

use App\Keyword;
use Maatwebsite\Excel\Concerns\ToModel;

class KeywordsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Keyword([
            "keyword" => $row[0]
        ]);
    }
}
