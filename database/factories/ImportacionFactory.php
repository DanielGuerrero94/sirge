<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Importacion;
use Faker\Generator as Faker;

$factory->define(Importacion::class, function (Faker $faker) {

	if (!function_exists('codigo_provincia')) {
		function codigo_provincia(Faker $faker) {
			$n = $faker->numberBetween(1, 24);
			return $n < 10?'0'.$n:''.$n;
		}	
	}	


	$id_provincia = codigo_provincia($faker);
    return [
		'id_provincia' => $id_provincia,
        'fecha' => $faker->dateTimeBetween('2020-01-01', 'now'),
        'original' => 'ejemplo-'.$id_provincia.'.csv'
    ];
});
