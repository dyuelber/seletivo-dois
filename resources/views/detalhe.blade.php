@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
			<a class="btn btn-primary" href="{{ route('/evento/presenca', Auth::user()->id) }}">Voltar</a>
	
			<div class="card">
                <div class="card-header"><b>{{ $evento->nome_evento }}</b></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

						<div class="form-group">
							<p><b>Descrição:</b> {{ $evento->descricao }}</p>
							
						</div>
						<div class="form-group">
							<p><b>Data Inicio:</b> {{ $evento->data_inicio }}</p>
							
						</div>
						<div class="form-group">
							
							<p><b>Data Fim:</b> {{ $evento->data_fim }}</p>
							
						</div>
						<div class="form-group">
							<p><b>Data de Notificação:</b> {{ $evento->data_notificacao }}</p>
						
						</div>
						<hr>
						<a class="btn btn-success" href="{{ route('/evento-pessoas/confirmacao', ['evento' => $evento->id, 'user_id' => Auth::user()->id ]) }}"> Confirmar Presença</a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection