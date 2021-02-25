<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Campeonato;


class GerenciamentoCampeonatoController extends Controller
{
    //    
    public function index()
    {
        $usuario = Auth::user();
        abort_if(!Auth::user()->admin, Response::HTTP_UNAUTHORIZED, '401 Não autorizado');
        $camps = Campeonato::all();
        return view('gerenciamento', compact('camps'));
    }

    public function criarCampeonato()
    {
        $usuario = Auth::user();
        abort_if(!Auth::user()->admin, Response::HTTP_UNAUTHORIZED, '401 Não autorizado');
        return view('criarCampeonato');
    }

    public function gravarCampeonato(Request $request)
    {
        $camp = Campeonato::create($request->all());
        return redirect()->route('gerenciamentoCampeonato');
    }
}
