<?php

namespace App\Imports;

use App\Template;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToCollection;

class ValidValuesImportSheet implements ToCollection
{
    public $name_template = null;
    public function __construct($name_template,$id_template)
    {
        $this->name_template = $name_template;
        $this->id_template = $id_template;
    }
    public function collection(Collection $collection)
    {
        $template = Template::findOrFail($this->id_template);
        dd($collection);
        Schema::table($template->table_name, function($table)
        {
            $table->string('name', 50)->change();
        });
    }
}
