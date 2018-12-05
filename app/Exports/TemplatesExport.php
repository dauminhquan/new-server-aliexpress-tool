<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class TemplatesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($table,$ids)
    {
        $this->ids = $ids;
        $this->table = $table;
    }

    public function collection()
    {
        $data = DB::table($this->table)->where('exported',"=",false);
        $ids = $this->ids;
        $data->where(function ($query) use ($ids){
           foreach ($ids as $id)
           {
               $query->orWhere('item_sku',"=",$id);
           }
        });
        $update = $data;
        $data = $data->get();
        $update->update(["exported" => true]);
        return $data;
    }
}
