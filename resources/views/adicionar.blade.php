@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
			<a class="btn btn-primary" href="{{ route('/eventos') }}">Voltar</a>
	
			<div class="card">
                <div class="card-header">{{ __('Adicionar Evento') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

					<form method="post" action="{{ route('/eventos') }}">
						@csrf
						<input type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}"/>
						<div class="form-group">    
							<label for="first_name">Nome evento</label>
							<input type="text" class="form-control" name="nome_evento"/>
						</div>
						<div class="form-group">
							<label for="last_name">Descrição</label>
							<input type="text" class="form-control" name="descricao"/>
						</div>
						<div class="form-group">
							<label for="email">Data Início</label>
							<input type="datetime-local" class="form-control" name="data_inicio" />
						</div>
						<div class="form-group">
							<label for="city">Data Fim</label>
							<input type="datetime-local" class="form-control" name="data_fim"/>
						</div>
						<div class="form-group">
							<label for="country">Data de Notificação</label>
							<input type="datetime-local" class="form-control" name="data_notificacao"/>
						</div>
						                        
						<button type="submit" class="btn btn-primary">Adicionar</button>
					</form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
