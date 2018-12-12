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

        $data = DB::table($this->table);
        $data->orWhere('exported',"=",-3);
        $data->orWhere('exported',"=",-2);
        $data->orWhere('exported',"=",-1);

        $update = DB::table($this->table)->where('exported','>',-1);
        if($this->export_all == false)
        {
            $ids = $this->ids;
            $data->orWhere(function ($query) use ($ids){
                $query->where('exported',"=",0);
                $query->where(function ($query2) use ($ids){
                    foreach ($ids as $id)
                    {
                        $query2->orWhere('item_sku',"=",$id);
                        $query2->orWhere('parent_sku','=',$id);
                    }
                });

            });
            $update->where(function ($query) use ($ids){
                $query->where('exported',"=",0);
                $query->where(function ($query2) use ($ids){
                    foreach ($ids as $id)
                    {
                        $query2->orWhere('item_sku',"=",$id);
                        $query2->orWhere('parent_sku','=',$id);
                    }
                });

            });
        }
        $data->orderBy('exported','asc');

        $data = $data->get();
        $count = 0;

        foreach ($data as $item)
        {
            if(($item->parent_sku == null || $item->parent_sku == "") && ($item->standard_price != null && $item->standard_price != ""))
            {
                $count++;
            }
        }
        $upcs = Upc::limit(count($data))->get();
        if(count($upcs) < $count)
        {
            dd("Khong du ma UPC");
        }
        else{
            $delete = DB::table('upcs');
            $indexUpc = 0;
            $delete->where(function($query) use (&$data,$upcs,&$indexUpc){
                foreach ($data as $index => $item)
                {
                    if($item->standard_price != null && $item->standard_price != "" && $item->exported > -1)
                    {
                        $item->external_product_id = $upcs[$indexUpc]->key;
                        $query->orWhere('id',"=",$upcs[$indexUpc]->id);
                        $indexUpc++;
                    }
                    unset($item->exported);
                }
            });
            $delete->delete();
        }
        $update->update(["exported" => 1]);
        /*$dataExport = [];
        $head1 = DB::table($this->table)->where('exported',"=",-3);
        $head2 = DB::table($this->table)->where('exported',"=",-2);
        $head3 = DB::table($this->table)->where('exported',"=",-1);
        unset($head1->exported);
        unset($head2->exported);
        unset($head3->exported);
        $dataExport[] = $head1;
        $dataExport[] = $head2;
        $dataExport[] = $head3;
        foreach ($data as $item)
        {
            if($item->parent_child == "" || $item->parent_child == null)
            {
                $dataExport[$item];
            }
            else if($item->parent_child == "Parent"){
                $this->setChild($dataExport,$data,$item->item_sku);
            }
        }*/
        return $data;
    }
    private function setChild(&$dataExport,$data,$parent_sku)
    {
        foreach ($data as $item)
        {
            if($item->parent_sku == $parent_sku)
            {
                $dataExport[] = $item;
            }
        }
    }
}
