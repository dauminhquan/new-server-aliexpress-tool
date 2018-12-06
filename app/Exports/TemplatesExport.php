<?php

namespace App\Exports;

use App\Upc;
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
        $count = count($data);
        $upcs = Upc::limit(count($data));
        if(count($upcs) < $count)
        {
            dd("Khong du ma UPC");
        }
        else{
            $delete = DB::table('upcs');
            $delete->where(function($query) use (&$data,$upcs){
                foreach ($data as $index => $item)
                {
                    $item->external_product_id = $upcs[$index]->key;
                    $query->orWhere('id',"=",$upcs[$index]->id);
                }
            });
            $delete->delete();
        }
        $update->update(["exported" => 1]);
        return $data;
    }
}
