<?php

use Illuminate\Database\Seeder;
use App\TipoAdvertencia;

class TipoAdvertenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		$advertencias = [
			['column' => 'beneficiario_clase_documento', 'message' => 'La clase de documento del beneficiario no es valida'],
			['column' => 'beneficiario_tipo_documento', 'message' => 'El tipo de documento no es valido'],
		];
		foreach($advertencias as $advertencia) {
			TipoAdvertencia::create($advertencia);
		}
	
    }
}
