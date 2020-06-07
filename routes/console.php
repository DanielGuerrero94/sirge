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

Artisan::command('db:diccionario {table?}', function ($table = 'prestaciones') {
	$query = <<<HEREDOC
SELECT (ordinal_position - 2) as ordinal_position, column_name, CASE 
WHEN character_maximum_length is not null THEN CONCAT(data_type, '(', character_maximum_length, ')') 
WHEN data_type = 'numeric' and numeric_precision is not null and numeric_scale is not null THEN CONCAT(data_type, '(', numeric_precision, ',', numeric_scale, ')') 
ELSE data_type 
END from information_schema.columns 
where table_name = '$table' and ordinal_position != 1 and ordinal_position != 2
and column_name != 'created_at' and column_name != 'updated_at'
order by ordinal_position;
HEREDOC;
	$result = DB::select($query);
	dump($result);
})->describe('Display column and type of a table');

Artisan::command('prestaciones:seed {amount}', function (int $amount) {
	factory(Prestacion::class, $amount)->create();
})->describe('Display column and type of a table');

Artisan::command('prestaciones:ejemplo {amount}', function (int $amount) {
	$prestaciones = factory(Prestacion::class, $amount)->create();
	$prestaciones->each(function($prestacion) {
		dump($prestacion->toArray());
	});

	/*
	if (($handle = fopen("storage/app/prestaciones.csv", "w")) !== FALSE) {
			$headers = fgetcsv($handle, 1000, ";");
			for($i = 1;($data = fgetcsv($handle, 1000, ";")) !== FALSE; $i++) {
	        //$num = count($data);
				$data = array_map(function($value) {
				   return $value === "" ? NULL : $value;
				}, $data);
				$data = array_combine($headers, $data);
				Prestacion::create($data);
			}
    	}	
    fclose($handle);
	*/
})->describe('Display column and type of a table');

Artisan::command('prestaciones:migrate', function (Faker $faker) {
})->describe('Display column and type of a table');


Artisan::command('jobs:importacion', function() {
	\App\Jobs\ImportacionJob::withChain([
	    new \App\Jobs\BeneficiarioCheckJob
	])->dispatch();
});

Artisan::command('jobs:check', function() {
	\App\Jobs\BeneficiarioCheckJob::dispatch();
});


Artisan::command('importacion:status', function() {
	$result = \DB::select("select count(*) from prestaciones;");
	$this->info(json_encode($result));
});

