<?php

namespace App\Http\Controllers;

use App\Models\InscricaoCampeonato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Campeonato;

class InscricaoCampeonatoController extends Controller
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
    public function create($id)
    {
        $campeonato = Campeonato::where('id', '=', $id)->first();
        return view('inscricaoTime', compact('campeonato'));
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
        $camp = InscricaoCampeonato::create(
            [
                'idJogador' => auth::user()->id,
                'idCampeonato' => $request->campeonatoID,
                'nomeTime' => $request->nomeTime,
                'nomeJogadores' => $request->nomeJogadores,
            ]
        );
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InscricaoCampeonato  $inscricaoCampeonato
     * @return \Illuminate\Http\Response
     */
    public function show(InscricaoCampeonato $inscricaoCampeonato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InscricaoCampeonato  $inscricaoCampeonato
     * @return \Illuminate\Http\Response
     */
    public function edit(InscricaoCampeonato $inscricaoCampeonato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InscricaoCampeonato  $inscricaoCampeonato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InscricaoCampeonato $inscricaoCampeonato)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InscricaoCampeonato  $inscricaoCampeonato
     * @return \Illuminate\Http\Response
     */
    public function destroy(InscricaoCampeonato $inscricaoCampeonato)
    {
        //
    }
}
