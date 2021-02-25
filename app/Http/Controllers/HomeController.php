<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\Campeonato;
use App\Models\InscricaoCampeonato;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuario = Auth::user();

        if ($usuario->admin) {
            return redirect()->route('gerenciamentoCampeonato');
        } else {
            $inscrito = InscricaoCampeonato::where('idJogador','=',$usuario->id)->get('idCampeonato')->toArray();
            $camps = Campeonato::where('dataLimiteInscricao','>=',date('Y-m-d'))->whereNotIn('id',$inscrito)->get();
            return view('home', compact('camps', 'usuario'));
        }
    }
}
