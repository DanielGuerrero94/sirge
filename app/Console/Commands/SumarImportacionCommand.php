<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ImportacionController;
use Illuminate\Http\Request;

class SumarImportacionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sumar:importacion {provincia} {periodo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importacion desde la terminal, necesita especificar el nombre de la provincia y usa por deafault un nombre de archivo';

	protected $provincias = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ImportacionController $controller)
    {
        parent::__construct();
   		$this->controller = $controller;
		$this->provincias = [
			'CABA' => '01',
			'BUENOS AIRES' => '02',
			'CATAMARCA' => '03',
			'CORDOBA' => '04',
			'CORRIENTES' => '05',
			'ENTRE RIOS' => '06',
			'JUJUY' => '07',
			'LA RIOJA' => '08',
			'MENDOZA' => '09',
			'SALTA' => '10',
			'SAN JUAN' => '11',
			'SAN LUIS' => '12',
			'SANTA FE' => '13',
			'SANTIAGO DEL ESTERO' => '14',
			'TUCUMAN' => '15',
			'CHACO' => '16',
			'CHUBUT' => '17',
			'FORMOSA' => '18',
			'LA PAMPA' => '19',
			'MISIONES' => '20',
			'NEUQUEN' => '21',
			'RIO NEGRO' => '22',
			'SANTA CRUZ' => '23',
			'TIERRA DEL FUEGO' => '24',
		];

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$provincia = $this->argument('provincia');
		$periodo = $this->argument('periodo');
		$id_provincia = $this->provincias[$provincia];
		$request = new Request([
			'id_provincia' => $id_provincia,
			'filename' => 'prestaciones_'.$id_provincia.'.csv',
			'periodo' => $periodo
		]);
		$response = $this->controller->store($request);
		dump($response);
    }
}
