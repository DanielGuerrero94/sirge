<?php

use Illuminate\Database\Seeder;

class LaPampaAuditoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if (($handle = fopen("storage/app/la_pampa_auditoria.csv", "r")) !== FALSE) {
			$headers = fgetcsv($handle, 1000, ";");
			for($i = 1;($data = fgetcsv($handle, 1000, ";")) !== FALSE; $i++) {
				$data = array_map(function($value) {
				   return $value === "" ? NULL : $value;
				}, $data);
				$data = array_combine($headers, $data);
				dump($data);
				DB::table('la_pampa_auditoria')->insert($data);
			}
    	}	
	    fclose($handle);
    }
}
