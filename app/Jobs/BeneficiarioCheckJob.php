<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BeneficiarioCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $jobs = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->jobs = [
			new ClaseDocumentoComunidadJob,
			new ClaseDocumentoJob,
			new ClaveBeneficiarioJob,
			new FechaDeNacimientoJob,
			new SexoBeneficiarioJob,
			new TipoDocumentoComunidadJob,
			new TipoDocumentoJob
		];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $jobs = collect($this->jobs);
		$jobs->each(function($job) {
			$job->dispatch();
		});
    }
}
