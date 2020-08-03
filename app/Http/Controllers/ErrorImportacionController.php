<?php

namespace App\Http\Controllers;

use App\ErrorImportacion;
use Illuminate\Http\Request;

class ErrorImportacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return datatables()->of(ErrorImportacion::all())->toJson();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ErrorImportacion  $errorImportacion
     * @return \Illuminate\Http\Response
     */
    public function show(ErrorImportacion $errorImportacion)
    {
		\Log::info(json_encode($errorImportacion));
        return \DB::select('select * from v_errores_importacion e where e.id_importacion = '.$errorImportacion->id_importacion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ErrorImportacion  $errorImportacion
     * @return \Illuminate\Http\Response
     */
    public function edit(ErrorImportacion $errorImportacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ErrorImportacion  $errorImportacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ErrorImportacion $errorImportacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ErrorImportacion  $errorImportacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ErrorImportacion $errorImportacion)
    {
        //
    }

	public function errores(int $id_importacion = 1)
	{
        return \DB::select('select * from v_errores_importacion e where e.id_importacion = '.$id_importacion);
	}
}
