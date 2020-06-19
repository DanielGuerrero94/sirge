<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;
use App\Advertencia;

class CheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $procedure;
	protected $column;
	protected $id_tipo_advertencia;
	protected $id_importacion;
	protected $id_provincia;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bag)
    {
        $this->id_importacion = $bag['id_importacion'];
        $this->id_provincia = $bag['id_provincia'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$query = 'select * from '.$this->procedure.'('.$this->id_importacion.',\''.$this->id_provincia.'\')';
		$result = DB::select($query);

		$advertencias =	array_map(function($value) {
			$value = (array) $value;		
			return [
				'id_importacion' => $this->id_importacion,
				'id_provincia' => $this->id_provincia,
				'id_prestacion' => $value['id_prestacion'],
				'id_tipo_advertencia' => $this->id_tipo_advertencia,
				'value' => $value[$this->column]
			];
		}, $result);

		foreach($advertencias as $advertencia) {
			Advertencia::create($advertencia);
		}

    }
}
