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

	/**
     * Show the state of the jobs.
     *
     * @param  \App\Advertencia  $advertencia
     * @return \Illuminate\Http\Response
     */
    public function jobs(int $id_importacion = 1)
    {
        return \DB::select('select ta.id as id_tipo_advertencia, ta.column, ta.message, a.status, (select count(*) from advertencias ad where ad.id_importacion = a.id::int and ad.id_tipo_advertencia = ta.id) from tipo_advertencias ta left join v_jobs_analisis a on a.id_tipo_advertencia::int = ta.id where a.id::int = '.$id_importacion);
    }

}
