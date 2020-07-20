<?php

namespace App\Http\Controllers;

use App\Importacion;
use App\Jobs\ImportacionJob;
use Illuminate\Http\Request;

class ImportacionController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['store', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//$importaciones = Importacion::select('id_provincia', 'periodo', 'fecha', 'facturadas', 'liquidadas', 'pagadas', 'total')->where('periodo', '-------')->get()->toArray();
		//dump($importaciones);
		$importaciones = \DB::select("select * from v_importacion_resumen");
		return datatables()->of($importaciones)->toJson();
    }

    /**
     * Show progress.
     *
     * @return \Illuminate\Http\Response
     */
    public function progress()
    {
		$counts = DB::table('prestaciones')->select('count(*)')->where('created_at', '>=', $importaciones[0]->fecha)->get();
		dump($importaciones);
		return datatables()->of($importaciones)->toJson();
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
        $periodo = $request->periodo;
        $id_provincia = $request->id_provincia;
        $filename = $request->filename;

		if(is_null($periodo))
			return response()->json(['mensaje' => 'Tiene que especificar un periodo'], 400);

		if(is_null($id_provincia))
			return response()->json(['mensaje' => 'Tiene que especificar el id de provincia'], 400);

		if(is_null($filename))
			return response()->json(['mensaje' => 'Tiene que especificar el nombre de archivo'], 400);


		
		$data = compact('id_provincia', 'periodo', 'filename');
		ImportacionJob::dispatch($data)->onQueue($id_provincia.'-queue');

		return response()->json(['mensaje' => 'Se subio la importacion'], 200);
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
