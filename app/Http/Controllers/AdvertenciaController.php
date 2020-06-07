<?php

namespace App\Http\Controllers;

use App\Advertencia;
use Illuminate\Http\Request;

class AdvertenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return datatables()->of(Advertencia::all())->toJson();
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
     * @param  \App\Advertencia  $advertencia
     * @return \Illuminate\Http\Response
     */
    public function show(Advertencia $advertencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advertencia  $advertencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertencia $advertencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advertencia  $advertencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertencia $advertencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advertencia  $advertencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertencia $advertencia)
    {
        //
    }
}
