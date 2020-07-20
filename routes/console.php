<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

use App\Prestacion;
use Faker\Generator as Faker;
use App\Jobs\ImportancionJob;

Artisan::command('unzip', function () {
	$filename = '276.zip';
	$path = storage_path('app/'.$filename);
	
	$this->info($filename);

	$data = system('unzip '.$filename);

	$this->info($data);	
})->describe('Unzip a file');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('sumar:diccionario {table?}', function ($table = 'prestaciones') {
	//$headers = ['id', 'tabla', 'orden', 'campo', 'tipo', 'obligatorio', 'descripcion', 'ejemplo', 'created_at', 'updated_at'];
	$headers = ['orden', 'campo', 'tipo', 'ejemplo'];
	//$diccionario = App\Diccionario::where('tabla', $table)->get()->toArray();
	$diccionario = App\Diccionario::select('orden', 'campo', 'tipo', 'ejemplo')->where('tabla', $table)->get()->toArray();
	$this->table($headers, $diccionario);
})->describe('Display column and type of a table');

Artisan::command('sumar:seed {amount} {id_provincia?}', function (int $amount, string $id_provincia = '01') {
	$id_provincias = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'];
	for($i = 0; $i < count($id_provincias); $i++) {
		$id_provincia = $id_provincias[$i];
		factory(Prestacion::class, $amount/2)->create(['id_provincia' => $id_provincia]);
		$this->info($amount/2);
		$this->info($i." - facturadas");
		factory(Prestacion::class, $amount/2)->state('liquidada')->create(['id_provincia' => $id_provincia]);
		$this->info($amount/2);
		$this->info($i." - liquidadas");
	}
})->describe('Display column and type of a table');


Artisan::command('sumar:check', function() {
	$id_importacion = 1;
	$id_provincia = '01';

	$jobBag = [
			'id_importacion' => $id_importacion,
			'id_provincia' => $id_provincia,
		];


        $jobs = [
			//new ClaseDocumentoComunidadJob,
			//new ClaseDocumentoJob,
			//new ClaveBeneficiarioJob,
new App\Jobs\FechaDeNacimientoJob($jobBag),
new App\Jobs\NombreBeneficiarioJob($jobBag),
new App\Jobs\ApellidoBeneficiarioJob($jobBag),
new App\Jobs\SexoBeneficiarioJob($jobBag),
new App\Jobs\TipoDocumentoJob($jobBag),
new App\Jobs\IdFacturaJob($jobBag),
new App\Jobs\IdLiquidacionJob($jobBag),
new App\Jobs\IdOpJob($jobBag),
			//new TipoDocumentoComunidadJob,
		];

	  foreach($jobs as $job) {
		$job->dispatch($jobBag)->onQueue($id_provincia.'-queue');
	  }
});

Artisan::command('sumar:status', function() {
	$result = \DB::select("select count(*) from prestaciones;");
	$this->info(json_encode($result));
});

Artisan::command('sumar:export', function() {
	$query = "\copy (select id_prestacion,prestacion_codigo,cuie,prestacion_fecha,beneficiario_apellido,beneficiario_nombre,beneficiario_clave,beneficiario_tipo_documento,beneficiario_clase_documento,beneficiario_nro_documento,beneficiario_sexo,beneficiario_nacimiento,valor_unitario_facturado,cantidad_facturado,importe_prestacion_facturado,id_factura,factura_nro,factura_fecha,factura_importe_total,factura_fecha_recepcion,alta_complejidad,id_liquidacion,liquidacion_fecha,valor_unitario_aprobado,cantidad_aprobada,importe_prestacion_aprobado,numero_comprobante_extracto_bancario,id_dato_reportable_1,dato_reportable_1,id_dato_reportable_2,dato_reportable_2,id_dato_reportable_3,dato_reportable_3,id_dato_reportable_4,dato_reportable_4,id_dato_reportable_5,dato_reportable_5,id_op,numero_op,fecha_op,importe_total_op,numero_expte,fecha_debito_bancario,importe_debito_bancario,fecha_notificacion_efector from prestaciones where id_provincia = '02') TO '/var/www/html/sirge-api/storage/app/prestaciones_02.csv' DELIMITER ';' CSV HEADER;";
	$this->info($query);
});


Artisan::command("sumar:csv", function () {
		if (($handle = fopen("database/diccionario.csv", "r")) !== FALSE) {
			$headers = fgetcsv($handle, 1000, ";");
			for($i = 1;($data = fgetcsv($handle, 1000, ";")) !== FALSE; $i++) {
				$data = array_map(function($value) {
				   return $value === "" ? NULL : $value;
				}, $data);
				$data = array_combine($headers, $data);
				dump($data);
			}
    	}	
	    fclose($handle);
});

Artisan::command("sumar:most", function () {
//Las 10 prestacion que mas se facturan
//$prestaciones = DB::connection('sirge')->select("select codigo_prestacion, count(*) from prestaciones.prestaciones group by codigo_prestacion order by count(*) desc limit 10");
//dump($prestaciones);
//El efector que mas factura
$prestaciones = DB::connection('sirge')->select("select efector, count(*) from prestaciones.prestaciones group by efector order by count(*) desc limit 10");
dump($prestaciones);
});

Artisan::command("sumar:query", function () {
$query = <<<HEREDOC
\copy (
select 
p.id as id_prestacion,
p.codigo_prestacion as prestacion_codigo,
p.efector as cuie,
p.fecha_prestacion as prestacion_fecha,
null as beneficiario_apellido,
null as beneficiario_nombre,
p.clave_beneficiario as beneficiario_clave,
p.tipo_documento as beneficiario_tipo_documento,
p.clase_documento as beneficiario_clase_documento,
p.numero_documento as beneficiario_nro_documento,
null as beneficiario_sexo,
null as beneficiario_nacimiento,
p.precio_unitario as valor_unitario_facturado,
null as cantidad_facturado,
null as importe_prestacion_facturado,
null as id_factura,
p.numero_comprobante as factura_nro,
c.fecha_comprobante as factura_fecha,
c.importe as factura_importe_total,
c.fecha_recepcion as factura_fecha_recepcion,
null as alta_complejidad,
null as id_liquidacion,
c.fecha_liquidacion  as liquidacion_fecha,
null as valor_unitario_aprobado,
null as cantidad_aprobada,
null as importe_prestacion_aprobado,
null as numero_comprobante_extracto_bancario,
null as id_dato_reportable_1,
null as dato_reportable_1,
null as id_dato_reportable_2,
null as dato_reportable_2,
null as id_dato_reportable_3,
null as dato_reportable_3,
null as id_dato_reportable_4,
null as dato_reportable_4,
null as id_dato_reportable_5,
null as dato_reportable_5,
null as id_op,
null as numero_op,
null as fecha_op,
c.importe_pagado as importe_total_op,
null as numero_expte,
c.fecha_debito_bancario as fecha_debito_bancario,
null as importe_debito_bancario,
c.fecha_notificacion as fecha_notificacion_efector
from prestaciones.prestaciones p
join comprobantes.comprobantes c on c.efector = p.efector and c.numero_comprobante = p.numero_comprobante
where p.lote = '20503'
)
to '/tmp/lote_20503.csv'
delimiter ';' csv header;
HEREDOC;

$this->info($query);
});
/*
CASE WHEN a."FECHA_LIQUIDACION" is not null THEN CAST ( a."FECHA_LIQUIDACION" as date) as liquidacion_fecha ELSE CAST(p.) END,
*/

Artisan::command("sumar:la_pampa", function () {
$query = <<<HEREDOC
drop view if exists la_pampa;
create view la_pampa as (
select 
a."id_Prestacion" as id_prestacion,
CAST ( a."Codigo_Prestacion" as character varying(11)) as prestacion_codigo,
CAST ( a."Cuie_Efector" as character(6)) as cuie,
CAST ( a."Fecha_Prestacion" as date) as prestacion_fecha,
CAST ( a."Apellido_Beneficiario" as character varying(100)) as beneficiario_apellido,
CAST ( a."Nombre_Beneficiario" as character varying(100)) as beneficiario_nombre,
CAST ( a."clave_Beneficiario" as character varying(16)) as beneficiario_clave,
CAST ( a."BENEF_TIPO_DOCUMENTO" as character(3)) as beneficiario_tipo_documento,
CAST ( a."BENEF_CLASE_DOCUMENTO" as character(1)) as beneficiario_clase_documento,
CAST ( a."BENEF_NUMERO_DOCUMENTO" as character varying(14)) as beneficiario_nro_documento,
CAST ( a."SEXO" as character(1)) as beneficiario_sexo,
CAST ( a."FECHA_DE_NACIMIENTO" as date) as beneficiario_nacimiento,
CAST ( a."VALOR_UNITARIO" as numeric(9,2)) as valor_unitario_facturado,
CAST ( a."CANTIDAD" as integer) as cantidad_facturado,
null as importe_prestacion_facturado,
null as id_factura,
CAST ( a."NUM_FACTURA" as character varying(100)) as factura_nro,
CAST ( a."FECHA_FACTURA" AS date) as factura_fecha,
CAST ( a."IMPORTE_FACTURADO" as numeric(9,2)) as factura_importe_total,
null as factura_fecha_recepcion,
null as alta_complejidad,
null as id_liquidacion,
CAST ( a."FECHA_LIQUIDACION" as date) as liquidacion_fecha,
null as valor_unitario_aprobado,
null as cantidad_aprobada,
null as importe_prestacion_aprobado,
null as numero_comprobante_extracto_bancario,
cast(p.id1 as integer) as id_dato_reportable_1,
cast(p.dato_id1 as character varying(255))as dato_reportable_1,
cast(p.id2 as integer) as id_dato_reportable_2,
cast(p.dato_id2 as character varying(255)) as dato_reportable_2,
cast(p.id3 as integer) as id_dato_reportable_3,
cast(p.dato_id3 as character varying(255)) as dato_reportable_3,
cast(p.id4 as integer) as id_dato_reportable_4,
cast(p.dato_id4 as character varying(255)) as dato_reportable_4,
null as id_dato_reportable_5,
null as dato_reportable_5,
null as id_op,
null as numero_op,
null as fecha_op,
null as importe_total_op,
CAST ( a."NUMERO_EXP" as character varying(100)) as numero_expte,
null as fecha_debito_bancario,
null as importe_debito_bancario,
null as fecha_notificacion_efector
from la_pampa_prestaciones p
join la_pampa_auditoria a on a."id_Prestacion" = p.id_prest
);
HEREDOC;
$this->info($query);
/*
$result = DB::select($query);
dump($result);
*/
});


Artisan::command("sumar:validar", function () {
	$jobBag = [
		'id_importacion' => 1,
		'id_provincia' => "19",
	];

    $this->jobs = [
		//new ClaseDocumentoComunidadJob,
		new App\Jobs\ClaseDocumentoJob($jobBag),
		//new ClaveBeneficiarioJob,
		new App\Jobs\FechaDeNacimientoJob($jobBag),
		new App\Jobs\NombreBeneficiarioJob($jobBag),
		new App\Jobs\ApellidoBeneficiarioJob($jobBag),
		new App\Jobs\SexoBeneficiarioJob($jobBag),
		new App\Jobs\TipoDocumentoJob($jobBag),
		//new TipoDocumentoComunidadJob,
	];

	foreach($this->jobs as $job) {
		dispatch($job);
	}
});

Artisan::command("sumar:provincias", function () {
		$provincias = [
			'CABA' => '01',
			'BUENOS AIRES' => '02',
			'CATAMARCA' => '03',
			'CORDOBA' => '04',
			'CORRIENTES' => '05',
			'ENTRE RIOS' => '06',
			'JUJUY' => '07',
			'LA RIOJA' => '08',
			'MENDOZA' => '09',
			'SALTA' => '10',
			'SAN JUAN' => '11',
			'SAN LUIS' => '12',
			'SANTA FE' => '13',
			'SANTIAGO DEL ESTERO' => '14',
			'TUCUMAN' => '15',
			'CHACO' => '16',
			'CHUBUT' => '17',
			'FORMOSA' => '18',
			'LA PAMPA' => '19',
			'MISIONES' => '20',
			'NEUQUEN' => '21',
			'RIO NEGRO' => '22',
			'SANTA CRUZ' => '23',
			'TIERRA DEL FUEGO' => '24',
		];
	dd($provincias);
});


