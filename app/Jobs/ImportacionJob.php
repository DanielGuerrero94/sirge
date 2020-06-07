<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Prestacion;

class ImportacionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

		factory(Prestacion::class, 2000)->create();
/*
		if (($handle = fopen("storage/app/prestaciones.csv", "r")) !== FALSE) {
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
    }
}
