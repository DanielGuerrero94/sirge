<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define('App\Prestacion', function (Faker $faker) {

	if (!function_exists('codigo_provincia')) {
		function codigo_provincia(Faker $faker) {
			$n = $faker->numberBetween(1, 24);
			return $n < 10?'0'.$n:''.$n;
		}	
	}	


	$id_provincia = codigo_provincia($faker);
	$prestacion_fecha = $faker->dateTimeBetween('2020-01-01', 'now');
	$sexo = $faker->randomElement(array('F', 'N', 'M'));
	$nombre = $sexo == 'F'?$faker->firstName('female'):$faker->firstName('male');
	$tipo_documento = $faker->randomElement(array('DNI', 'PAS', 'LC', 'LE', 'CI', 'CM', 'NNN')); 
	$clase_documento = $faker->randomElement(array('A', 'N', 'P', 'C')); 
	$numero_documento = $faker->numberBetween(10000000, 50000000); 
	$nacimiento = $faker->dateTimeBetween('-50 years', $prestacion_fecha);
	$valor_unitario_facturado = $faker->randomFloat(2, 0, 99999);
	$cantidad_facturado = $faker->randomDigit();
	$importe_prestacion_facturado = $valor_unitario_facturado * $cantidad_facturado;
	$factura_fecha = $faker->dateTimeBetween($prestacion_fecha, 'now');
	$factura_fecha_recepcion = $faker->dateTimeBetween($factura_fecha, 'now');
	$alta_complejidad = $faker->randomElement(array('S', 'N'));

    return [
    	'id_provincia' => $id_provincia,
    	'id_prestacion' => $faker->randomNumber(),
    	'prestacion_codigo' => 'C01202',
    	'cuie' => 'E02345',
		'prestacion_fecha' => $prestacion_fecha,
		'beneficiario_apellido' => $faker->lastName(),
		'beneficiario_nombre' => $nombre,
		'beneficiario_clave' => $faker->randomNumber(),
		'beneficiario_tipo_documento' => $tipo_documento,
		'beneficiario_clase_documento' => $clase_documento,
		'beneficiario_nro_documento' => $numero_documento,
		'beneficiario_sexo' => $sexo,
		'beneficiario_nacimiento' => $nacimiento,
		'valor_unitario_facturado' => $valor_unitario_facturado,
		'cantidad_facturado' => $cantidad_facturado,
		'importe_prestacion_facturado' => $importe_prestacion_facturado,
		'id_factura' => $faker->randomNumber(),
		'factura_nro' => $faker->randomNumber(),
		'factura_fecha' => $faker->randomNumber(),
		'factura_fecha' => $factura_fecha,
		'factura_importe_total' => $importe_prestacion_facturado,
		'factura_fecha_recepcion' => $factura_fecha_recepcion, 
		'alta_complejidad' => $alta_complejidad
/*
    id_liquidacion integer,
    liquidacion_fecha date,
    valor_unitario_aprobado numeric(7,2),
    cantidad_aprobada integer,
    importe_prestacion_aprobado numeric(9,2),
    id_dato_reportable_1 integer,
    dato_reportable_1 character varying(255),
    id_dato_reportable_2 integer,
    dato_reportable_2 character varying(255),
    id_dato_reportable_3 integer,
    dato_reportable_3 character varying(255),
    id_dato_reportable_4 integer,
    dato_reportable_4 character varying(255),
    id_op integer,
    numero_op character varying(100),
    fecha_op date,
    importe_total_op numeric(7,2),
    numero_expte character varying(100),
    fecha_debito_bancario date,
    importe_debito_bancario numeric(9,2),
    fecha_notificacion_efector date
*/
    ];
});

$factory->state('App\Prestacion', 'liquidada', function (Faker $faker) {

	if (!function_exists('codigo_provincia')) {
		function codigo_provincia(Faker $faker) {
			$n = $faker->numberBetween(1, 24);
			return $n < 10?'0'.$n:''.$n;
		}	
	}	


	$id_provincia = codigo_provincia($faker);
	$prestacion_fecha = $faker->dateTimeBetween('2020-01-01', 'now');
	$sexo = $faker->randomElement(array('F', 'N', 'M'));
	$nombre = $sexo == 'F'?$faker->firstName('female'):$faker->firstName('male');
	$tipo_documento = $faker->randomElement(array('DNI', 'PAS', 'LC', 'LE', 'CI', 'CM', 'NNN')); 
	$clase_documento = $faker->randomElement(array('A', 'N', 'P', 'C')); 
	$numero_documento = $faker->numberBetween(10000000, 50000000); 
	$nacimiento = $faker->dateTimeBetween('-50 years', $prestacion_fecha);
	$valor_unitario_facturado = $faker->randomFloat(2, 0, 99999);
	$cantidad_facturado = $faker->randomDigit();
	$importe_prestacion_facturado = $valor_unitario_facturado * $cantidad_facturado;
	$factura_fecha = $faker->dateTimeBetween($prestacion_fecha, 'now');
	$factura_fecha_recepcion = $faker->dateTimeBetween($factura_fecha, 'now');
	$alta_complejidad = $faker->randomElement(array('S', 'N'));

	$liquidacion_fecha = $faker->dateTimeBetween($factura_fecha_recepcion, 'now');
	$valor_unitario_aprobado = $faker->randomFloat(2, 0, 99999);
	$cantidad_aprobada = $faker->randomDigit();
	$importe_prestacion_aprobado = $valor_unitario_aprobado * $cantidad_aprobada;


    return [
    	'id_provincia' => $id_provincia,
    	'id_prestacion' => $faker->randomNumber(),
    	'prestacion_codigo' => 'C01202',
    	'cuie' => 'E02345',
		'prestacion_fecha' => $prestacion_fecha,
		'beneficiario_apellido' => $faker->lastName(),
		'beneficiario_nombre' => $nombre,
		'beneficiario_clave' => $faker->randomNumber(),
		'beneficiario_tipo_documento' => $tipo_documento,
		'beneficiario_clase_documento' => $clase_documento,
		'beneficiario_nro_documento' => $numero_documento,
		'beneficiario_sexo' => $sexo,
		'beneficiario_nacimiento' => $nacimiento,
		'valor_unitario_facturado' => $valor_unitario_facturado,
		'cantidad_facturado' => $cantidad_facturado,
		'importe_prestacion_facturado' => $importe_prestacion_facturado,
		'id_factura' => $faker->randomNumber(),
		'factura_nro' => $faker->randomNumber(),
		'factura_fecha' => $faker->randomNumber(),
		'factura_fecha' => $factura_fecha,
		'factura_importe_total' => $importe_prestacion_facturado,
		'factura_fecha_recepcion' => $factura_fecha_recepcion, 
		'alta_complejidad' => $alta_complejidad,
    	'id_liquidacion' => $faker->randomNumber(),
		'liquidacion_fecha' => $liquidacion_fecha,
		'valor_unitario_aprobado' => $valor_unitario_aprobado,
		'cantidad_aprobada' => $cantidad_aprobada,
		'importe_prestacion_aprobado' => $importe_prestacion_aprobado,
    ];
});
