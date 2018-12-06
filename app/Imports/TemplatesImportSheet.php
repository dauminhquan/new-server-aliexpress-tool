<?php

namespace App\Imports;

use App\Template;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToCollection;

class TemplatesImportSheet implements ToCollection
{

    public $name_template = null;
    public function __construct($name_template,$id_template)
    {
        $this->name_template = $name_template;
        $this->id_template = $id_template;
    }

    public function collection(Collection $collection)
    {
        try{
            $columns = [];
            $defaults = [];
            $row1 = [];
            $row0 = [];
            foreach ($collection as $key => $item )
            {
                if($key == 0)
                {
                    $row0 = $item;
                }
                if($key == 1)
                {
                    $row1 = $item;
                }
                if($key == 2)
                {
                    $columns = $item;
                }
                if($key == 3)
                {
                    $defaults = $item;
                }
            }
            if(!$this->checkTemplate($columns))
            {
                Schema::dropIfExists($this->name_template);
                dd([
                    "message" => "Template Error"
                ]);
            }
            $template = Template::findOrFail($this->id_template);
            $sort = [];
            foreach ($columns as $column)
            {
                $sort[] = $column;
            }
            $template->sort = implode(";",$sort);
            $template->update();
            Schema::create($this->name_template, function (Blueprint $table) use ($columns,$defaults) {
                foreach ($columns as $index => $column)
                {
                    if($column == "item_sku")
                    {
                        $table->string($column,40)->primary();
                    }
                    else if($column == "fulfillment_latency")
                    {
                        $table->string($column,40)->default("10")->nullable();
                    }
                    else if($column == "condition_type")
                    {
                        $table->string($column,40)->default("New")->nullable();
                    }
                    else if($column == "external_product_id_type")
                    {
                        $table->string($column,40)->default("UPC")->nullable();
                    }
                    else if($column == "quantity")
                    {
                        $table->string($column,40)->default("10")->nullable();
                    }
                    else if($defaults[$index] != null && $defaults[$index] != ""){
                        $table->string($column)->default($defaults[$index])->nullable();
                    }
                    else{
                        $table->text($column)->nullable();
                    }
                }
                $table->integer("exported")->default(0);
            });
            $insert0 = [];
            $insert1 = [];
            $insert2 = [];
            foreach ($columns as $index => $column)
            {
                $insert0[$column] = $row0[$index];
                $insert1[$column] = $row1[$index];
                $insert2[$column] = $column;
            }
            $insert0["exported"] = -3;
            $insert1["exported"] = -2;
            $insert2["exported"] = -1;
            DB::table($this->name_template)->insert($insert0);
            DB::table($this->name_template)->insert($insert1);
            DB::table($this->name_template)->insert($insert2);
        }catch (\Exception $exception){
            Schema::dropIfExists($this->name_template);
            dd([
                "message" => "Template Error"
            ]);
        }
    }
    private function checkTemplate($columns)
    {
        if(count($columns) < 10)
        {
            return false;
        }
        foreach ($columns as $column)
        {
            if('parent_sku' == $column)
            {
                return true;
            }
        }
        return false;
    }
}
