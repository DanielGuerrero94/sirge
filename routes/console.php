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

Artisan::command('sumar:seed {amount} {id_provincia}', function (int $amount, string $id_provincia = '01') {
	factory(Prestacion::class, $amount/2)->create(['id_provincia' => $id_provincia]);
	factory(Prestacion::class, $amount/2)->state('liquidada')->create(['id_provincia' => $id_provincia]);
})->describe('Display column and type of a table');

Artisan::command('sumar:importacion', function() {
	\App\Jobs\ImportacionJob::withChain([
	    new \App\Jobs\BeneficiarioCheckJob
	])->dispatch();
});

Artisan::command('sumar:check', function() {
	\App\Jobs\BeneficiarioCheckJob::dispatch();
});


Artisan::command('sumar:status', function() {
	$result = \DB::select("select count(*) from prestaciones;");
	$this->info(json_encode($result));
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
