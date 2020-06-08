<?php

namespace App\Exports;

use App\TipoAdvertencia;
use Maatwebsite\Excel\Concerns\FromCollection;

class TipoAdvertenciaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TipoAdvertencia::select('id', 'column', 'message')->get();
    }
}
