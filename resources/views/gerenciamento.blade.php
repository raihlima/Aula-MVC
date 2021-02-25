@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">{{ __('Tabela de Campeonatos') }}</div>

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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($camps as $camp)

                            <tr>
                                <td>{{$camp['nome']}}</td>
                                <td>{{App\Models\Campeonato::GAME_SELECT[$camp['jogo']??'']}}</td>
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$camp['dataLimiteInscricao'])->format('d/m/Y')}}</td>
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$camp['dataInicioCampeonato'])->format('d/m/Y')}}</td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>

                    <br><a href="{{route ("gerenciamentoCampeonato.criarCampeonato")}}" class="btn btn-primary">Cadastrar Campeonato</a>

            </div>
        </div>
    </div>
</div>
</div>
@endsection