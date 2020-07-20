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
			['column' => 'beneficiario_nombre', 'message' => 'El nombre del beneficiario no debe estar vacio'],
			['column' => 'beneficiario_apellido', 'message' => 'El apellido del beneficiario no debe estar vacio'],
			['column' => 'beneficiario_sexo', 'message' => 'El sexo del beneficiario no debe estar vacio'],
			['column' => 'beneficiario_nacimiento', 'message' => 'La fecha de nacimiento del beneficiario no debe estar vacia'],
			['column' => 'beneficiario_tipo_documento', 'message' => 'El tipo de documento no es valido'],
			['column' => 'beneficiario_clase_documento', 'message' => 'La clase de documento del beneficiario no es valida'],
			['column' => 'id_factura', 'message' => 'El id de factura no debe estar vacio'],
			['column' => 'id_liquidacion', 'message' => 'El id de la liquidacion no debe estar vacio'],
			['column' => 'id_op', 'message' => 'El id de la orden de pago no debe estar vacio'],
		];
		foreach($advertencias as $advertencia) {
			TipoAdvertencia::create($advertencia);
		}
	
    }
}
