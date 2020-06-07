<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;

class CheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $procedure;
	protected $column;
	protected $id_tipo_advertencia;

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
		$query = 'select * from '.$this->procedure.'()';
		dump($query);
		$result = DB::select($query);
		dump($result);

		$advertencias =	array_map(function($value) {
			return [
				'id_prestacion' => $value->id_prestacion,
				'id_provincia' => $value->id_provincia,
				'id_tipo_advertencia' => $value->$this->id_tipo_advertencia,
				'value' => $value->$this->column
			];
		}, $result);

		foreach($advertencias as $advertencia) {
			Advertencia::create($advertencia);
		}

    }
}
