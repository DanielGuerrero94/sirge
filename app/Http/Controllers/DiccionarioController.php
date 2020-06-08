<?php

namespace App\Http\Controllers;

use App\Diccionario;
use Illuminate\Http\Request;
use App\Exports\DiccionarioExport;
use Excel;

class DiccionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return datatables()->of(Diccionario::all())->toJson();
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
     * @param  \App\Diccionario  $diccionario
     * @return \Illuminate\Http\Response
     */
    public function show(Diccionario $diccionario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Diccionario  $diccionario
     * @return \Illuminate\Http\Response
     */
    public function edit(Diccionario $diccionario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Diccionario  $diccionario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diccionario $diccionario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Diccionario  $diccionario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diccionario $diccionario)
    {
        //
    }

	public function export (Request $request)
	{
		return Excel::download(new DiccionarioExport, 'diccionario.csv');
	}	
}
