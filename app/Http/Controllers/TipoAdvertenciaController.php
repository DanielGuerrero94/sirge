<?php

namespace App\Http\Controllers;

use App\TipoAdvertencia;
use Illuminate\Http\Request;
use App\Exports\TipoAdvertenciaExport;
use Excel;

class TipoAdvertenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return response()->json(TipoAdvertencia::all());
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
     * @param  \App\TipoAdvertencia  $tipoAdvertencia
     * @return \Illuminate\Http\Response
     */
    public function show(TipoAdvertencia $tipoAdvertencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoAdvertencia  $tipoAdvertencia
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoAdvertencia $tipoAdvertencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoAdvertencia  $tipoAdvertencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoAdvertencia $tipoAdvertencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoAdvertencia  $tipoAdvertencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoAdvertencia $tipoAdvertencia)
    {
        //
    }

	public function export(Request $request)
	{
		return Excel::download(new TipoAdvertenciaExport, 'tipo_advertencia.csv');
	}
}
