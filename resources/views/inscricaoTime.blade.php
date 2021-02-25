@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Inscrever Time') }} - {{ $campeonato['nome']}}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="{{route ("inscricao.store")}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nome do time:</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Realgoritmos" name='nomeTime' required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Jogadores:</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name='nomeJogadores' required></textarea>
                        </div>
                        <input type="hidden" name="campeonatoID" value="{{ $campeonato['id'] }}">
                        <input type="submit" value="Inscrever Time" class="btn btn-primary" />
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection