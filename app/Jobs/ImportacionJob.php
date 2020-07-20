<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Prestacion;
use App\Importacion;
use App\ErrorImportacion;
use Carbon\Carbon;
use Exception;
use PDOException;

class ImportacionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $jobs = [];
	protected $headers = [];
	protected $id_provincia;
	protected $periodo;
	protected $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
		$this->id_provincia = $data['id_provincia'];
		$this->periodo = $data['periodo'];
		$this->filename = '/var/www/html/sirge-api/storage/app/'.$data['filename'];

		
		$this->headers = ['id_prestacion','prestacion_codigo','cuie','prestacion_fecha','beneficiario_apellido','beneficiario_nombre','beneficiario_clave','beneficiario_tipo_documento','beneficiario_clase_documento','beneficiario_nro_documento','beneficiario_sexo','beneficiario_nacimiento','valor_unitario_facturado','cantidad_facturado','importe_prestacion_facturado','id_factura','factura_nro','factura_fecha','factura_importe_total','factura_fecha_recepcion','alta_complejidad','id_liquidacion','liquidacion_fecha','valor_unitario_aprobado','cantidad_aprobada','importe_prestacion_aprobado','numero_comprobante_extracto_bancario','id_dato_reportable_1','dato_reportable_1','id_dato_reportable_2','dato_reportable_2','id_dato_reportable_3','dato_reportable_3','id_dato_reportable_4','dato_reportable_4','id_dato_reportable_5','dato_reportable_5','id_op','numero_op','fecha_op','importe_total_op','numero_expte','fecha_debito_bancario','importe_debito_bancario','fecha_notificacion_efector'];

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$this->createImportation();

	
		if (($handle = fopen($this->filename, "r")) !== FALSE) {
			for($i = 1;($data = fgetcsv($handle, 1000, ";")) !== FALSE; $i++) {

				//Excepcion por headers, excepcion por cordoba
				if(in_array("id_prestacion", $data) || in_array("CUIE_Efector", $data)) {
					continue;
				}

				$data = array_map(function($value) {
				   return $value === "" ? NULL : $value;
				}, $data);

				try {
					$data = array_combine($this->headers, $data);
				} catch (\ErrorException $e) {
					\Log::error($e->getMessage());
					continue;	
				}
				$data['id_importacion'] = $this->id_importacion;
				$data['id_provincia'] = $this->id_provincia;

				if($this->id_provincia == '01') {
					$data['id_factura'] = substr($data['id_factura'], 0, strlen($data['id_factura']) - 8);	
				}

				$this->insertPrestacion($data);
			}
    	}	

	    fclose($handle);

		if ($handle !== FALSE)
			$this->runJobs();
		
    }

	public function insertPrestacion($data)
	{
	    try {
		    var_dump(["status" => "INSERT", "data" => $data]);
	  		Prestacion::create($data);
		} catch(PDOException $e) {
			if($e->getCode() == 22003) {
				preg_match('/Numeric.*SQL/s', $e->getMessage(), $matches);
				$mensaje = isset($matches[0])?$matches[0]:$e->getMessage();

				$this->createErrorImportacion($e, $mensaje, $data);
			} if($e->getCode() == 23502) {
				preg_match('/null value in column "id_importacion"/s', $e->getMessage(), $matches);
				$mensaje = isset($matches[0])?$matches[0]:$e->getMessage();

				$this->createErrorImportacion($e, $mensaje, $data);
			} else {
				$mensaje = $e->getMessage();
				$this->createErrorImportacion($e, $mensaje, $data);
			}
		} catch(Exception $e) {
			\Log::error($e->getMessage());
		}
	}

	public function createErrorImportacion($e, $mensaje, $data)
	{
		ErrorImportacion::create([
			'id_importacion' => $this->id_importacion,
			'id_provincia' => $this->id_provincia,
			'id_prestacion' => (int)$data['id_prestacion'],
			'codigo' => $e->getCode(),
			'mensaje' => json_encode($mensaje),
		]);
		\Log::error($e->getMessage());
	}

	public function createImportation()
	{
		$total = $this->getLinesCount();
		$fecha = Carbon::now();

		$importacion = Importacion::create([
			'id_provincia' => $this->id_provincia,
			'periodo' => $this->periodo,
			'fecha' => $fecha,
			'original' => $this->filename,
			'total' => $total,
			'facturadas' => 0,
			'liquidadas' => 0,
			'pagadas' => 0
		]);
		$this->id_importacion = $importacion->id;
		\Log::info($importacion);
	}

	public function getLinesCount()
	{
		$output = shell_exec('wc -l '. $this->filename);
		preg_match('/^[0-9]* /', $output, $matches);
		return $matches[0];
	}

	public function runJobs()
	{
		$jobBag = [
			'id_importacion' => $this->id_importacion,
			'id_provincia' => $this->id_provincia,
		];


        $this->jobs = [
			//new ClaseDocumentoComunidadJob,
			//new ClaseDocumentoJob,
			//new ClaveBeneficiarioJob,
			new FechaDeNacimientoJob($jobBag),
			new NombreBeneficiarioJob($jobBag),
			new ApellidoBeneficiarioJob($jobBag),
			new SexoBeneficiarioJob($jobBag),
			new TipoDocumentoJob($jobBag),
			new IdFacturaJob($jobBag),
			//new TipoDocumentoComunidadJob,
		];

	  foreach($this->jobs as $job) {
		$job->dispatch($jobBag)->onQueue($this->id_provincia.'-queue');
	  }
	}
	

}
