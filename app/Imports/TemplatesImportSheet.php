<?php

namespace App\Imports;

use App\Template;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
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
        $columns = [];
        $defaults = [];
        foreach ($collection as $key => $item )
        {
            if($key == 2)
            {
                $columns = $item;
            }
            if($key == 3)
            {
                $defaults = $item;
            }
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
                    $table->string("item_sku",40)->primary();
                }
                else if($defaults[$index] != null && $defaults[$index] != ""){
                    $table->string($column)->default($defaults[$index]);
                }
                else{
                    $table->text($column)->nullable();
                }
            }
            $table->boolean("exported")->default(false);
        });
    }
}
