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
        //Primero las de not null
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
			['column' => 'beneficiario_clave', 'message' => 'La clave de beneficiario no debe estar vacia'],
			['column' => 'beneficiario_nro_documento', 'message' => 'El numero de documento del beneficiario no debe estar vacio'],
			['column' => 'id_prestacion', 'message' => 'El id de prestacion no debe estar vacio'],
			['column' => 'prestacion_codigo', 'message' => 'El codigo de prestacion no debe estar vacio'],
			['column' => 'cuie', 'message' => 'El CUIE no debe estar vacio'],
			['column' => 'prestacion_fecha', 'message' => 'La fecha de prestacion no debe estar vacia'],
			['column' => 'valor_unitario_facturado', 'message' => 'El valor unitario facturado no debe estar vacio'],
			['column' => 'cantidad_facturado', 'message' => 'La cantidad facturada no debe estar vacia'],
			['column' => 'importe_prestacion_facturado', 'message' => 'El importe de prestacion facturado no debe estar vacio'],
			['column' => 'factura_nro', 'message' => 'El numero de factura no debe estar vacio'],
			['column' => 'factura_fecha', 'message' => 'La fecha de factura no debe estar vacia'],
			['column' => 'factura_importe_total', 'message' => 'El importe total de factura no debe estar vacio'],
			['column' => 'factura_fecha_recepcion', 'message' => 'La fecha de recepcion de factura no debe estar vacia'],
			['column' => 'alta_complejidad', 'message' => 'La prestacion debe indicar si es de alta complejidad'],
		];
		foreach($advertencias as $advertencia) {
			TipoAdvertencia::create($advertencia);
		}
	
    }
}
