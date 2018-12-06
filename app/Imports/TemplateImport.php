<?php

namespace App\Imports;

use App\Template;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class TemplateImport implements WithMultipleSheets
{
    public $name_template = null;
    public function __construct($name_template,$id_template)
    {

        $this->name_template = $name_template;
        $this->id_template = $id_template;
    }
    public function sheets(): array
    {
        return [
            "Template" => new TemplatesImportSheet($this->name_template,$this->id_template),
        ];

    }
}
