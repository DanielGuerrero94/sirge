<?php

namespace App\Exports;

use App\Diccionario;
use Maatwebsite\Excel\Concerns\FromCollection;

class DiccionarioExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Diccionario::select('orden', 'campo', 'tipo', 'descripcion', 'ejemplo')->get()->sortBy('orden');
    }
}
