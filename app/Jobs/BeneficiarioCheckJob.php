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
	protected $jobBag = [];
	protected $id_provincia;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bag)
    {
		$this->jobBag = [
			'id_importacion' => $bag['id_importacion'],
			'id_provincia' => $bag['id_provincia'],
		];

        $this->id_provincia = $bag['id_provincia'];


        $this->jobs = [
			new ApellidoBeneficiarioJob($bag),
			new ClaseDocumentoJob($bag),
			new ClaveBeneficiarioJob($bag),
			new FechaDeNacimientoJob($bag),
			new NombreBeneficiarioJob($bag),
			new SexoBeneficiarioJob($bag),
			new TipoDocumentoJob($bag)
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
		$bag = $this->jobBag;
		$jobs->each(function($job) use ($bag) {
			$job->dispatch($bag)->onQueue($bag['id_provincia'].'-queue');
		});
    }
}
