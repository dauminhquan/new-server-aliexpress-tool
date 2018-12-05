<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;

class TemplatesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($table,$ids,$export_all = false)
    {
        $this->ids = $ids;
        $this->table = $table;
        $this->export_all = $export_all;
    }

    public function collection()
    {

        $data = DB::table($this->table)->where('exported',"=",0);
        $data->orWhere('exported',"=",-3);
        $data->orWhere('exported',"=",-2);
        $data->orWhere('exported',"=",-1);
        $data->orderBy('exported','asc');
        $update = DB::table($this->table);
        if($this->export_all == false)
        {
            $ids = $this->ids;
            $data->where(function ($query) use ($ids){
                foreach ($ids as $id)
                {
                    $query->orWhere('item_sku',"=",$id);
                }
            });
            $update->where(function ($query) use ($ids){
                foreach ($ids as $id)
                {
                    $query->orWhere('item_sku',"=",$id);
                }
            });
        }
        $data = $data->get();
        $update->update(["exported" => 1]);
        return $data;
    }
}
