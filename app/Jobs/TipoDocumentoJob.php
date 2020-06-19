<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TipoDocumentoJob extends CheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $procedure = "check_tipo_documento";
	protected $column = "beneficiario_tipo_documento";
	protected $id_tipo_advertencia = 5;

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

}
