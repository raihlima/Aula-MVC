@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Campeonatos Inscritos') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Modalidade</th>
                                    <th>Data limite inscrição</th>
                                    <th>Data início das partidas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuario->inscricoes as $inscricao)

                                <tr>
                                    <td>{{$inscricao->retornaCampeonato()['nome']}}</td>
                                    <td>{{App\Models\Campeonato::GAME_SELECT[$inscricao->retornaCampeonato()['jogo']??'']}}</td>
                                    <td>{{$inscricao->retornaCampeonato()['dataLimiteInscricao']}}</td>
                                    <td>{{$inscricao->retornaCampeonato()['dataInicioCampeonato']}}</td>

                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
            <br>


            <div class="card">
                <div class="card-header">{{ __('Campeonatos') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Modalidade</th>
                                    <th>Data limite inscrição</th>
                                    <th>Data início das partidas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($camps as $camp)

                                <tr>
                                    <td>{{$camp['nome']}}</td>
                                    <td>{{App\Models\Campeonato::GAME_SELECT[$camp['jogo']??'']}}</td>
                                    <td>{{$camp['dataLimiteInscricao']}}</td>
                                    <td>{{$camp['dataInicioCampeonato']}}</td>
                                    <td><a href="{{route ("inscricaoTime", $camp['id'] )}}" class="btn btn-primary">Inscrever Time</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection