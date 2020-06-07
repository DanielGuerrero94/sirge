<?php

namespace App\Http\Controllers;

use App\Importacion;
use App\Prestacion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ImportacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return datatables()->of(Importacion::all())->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$id_provincia = $request->id_provincia;
		$id_provincia = '01';	
        //$filename = $request->file->originalName;
		$filename = "storage/app/prestaciones.csv";

		$output = shell_exec('wc -l '. $filename);
		preg_match('/^[0-9]* /', $output, $matches);
		$total = $matches[0];
	
		if (($handle = fopen($filename, "r")) !== FALSE) {
			$headers = fgetcsv($handle, 1000, ";");
			for($i = 1;($data = fgetcsv($handle, 1000, ";")) !== FALSE; $i++) {
				$data = array_map(function($value) {
				   return $value === "" ? NULL : $value;
				}, $data);
				$data = array_combine($headers, $data);

				if (isset($data['fecha_prestacion'])) {
					$fecha_prestacion = $data['fecha_prestacion'];
					$periodo = substr($fecha_prestacion, 0, 6);
					$importacion = Importacion::where('id_provincia', $id_provincia)->where('periodo', $periodo)->first();
					if ($importacion == null) {
						Importacion:create([
							'id_provincia' => $id_provincia,
							'periodo' => $periodo,
							'fecha' => Carbon::now(),
							'original' => $filename,
							'total' => $total,
							'facturadas' => 0,
							'liquidadas' => 0,
							'pagadas' => 0
						]);
					}
				}
				Prestacion::create($data);
			}
		}	

		if ($handle == FALSE) {
			fclose($handle);
			return response()->json(['status' => 'error', 'message' => 'No se puede abrir el archivo']);
		}
		fclose($handle);
	
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Importacion  $importancion
     * @return \Illuminate\Http\Response
     */
    public function show(Importacion $importancion)
    {
		$result = \DB::select("select count(*) from prestaciones;");
        return $result[0]->count;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Importacion  $importancion
     * @return \Illuminate\Http\Response
     */
    public function edit(Importacion $importancion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Importacion  $importancion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Importacion $importancion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Importacion  $importancion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Importacion $importancion)
    {
        //
    }
}
