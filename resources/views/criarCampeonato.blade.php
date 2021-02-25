@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">{{ __('Criar campeonato') }}</div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{route ("gerenciamentoCampeonato.gravarCampeonato")}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nome do campeonato:</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Campeonato Integalático XV" name='nome' required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Selecione o jogo:</label>
                        <select class="form-control" id="exampleFormControlSelect1" name='jogo' required>
                            @foreach(App\Models\Campeonato::GAME_SELECT as $key=>$label)
                            <option value="{{$key}}">{{$label}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Data limite inscrição:</label>
                        <input type="date" class="form-control datetime-local" id="exampleFormControlInput1" name='dataLimiteInscricao' required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Data início das partidas:</label>
                        <input type="date" class="form-control datetime-local" id="exampleFormControlInput1" name='dataInicioCampeonato' required>
                    </div>
                    <input type="submit" value="Criar campeonato" class="btn btn-primary" />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection