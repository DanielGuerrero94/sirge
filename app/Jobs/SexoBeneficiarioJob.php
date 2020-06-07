<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;
use App\Advertencia;


class SexoBeneficiarioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$result = DB::select("select * from check_sexo()");

		$advertencias =	array_map(function($value) {
			return [
				'prestacion_id' => $value->check_sexo,
				'column' => 'beneficiario_sexo',
				'message' => 'El sexo del beneficiario no valido'
			];
		}, $result);

		foreach($advertencias as $advertencia) {
			Advertencia::create($advertencia);
		}
    }
}
