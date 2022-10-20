<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArquivoRequest;
use App\Http\Requests\UpdateArquivoRequest;
use App\Models\Arquivo;

class ArquivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreArquivoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArquivoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function show(Arquivo $arquivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function edit(Arquivo $arquivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArquivoRequest  $request
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArquivoRequest $request, Arquivo $arquivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arquivo $arquivo)
    {
        //
    }
}
