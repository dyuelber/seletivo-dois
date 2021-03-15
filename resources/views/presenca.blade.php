@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
		<div class="col-10">
			
			@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
			@endif

			<a class="btn btn-primary" href="{{ route('home') }}">Voltar</a>
			<a class="btn btn-primary" href="{{ route('/evento-pessoas/confirmados', Auth::user()->id) }}">Eventos Confirmados</a>

			<div class="card">
                <div class="card-header">
					Novos Eventos
				</div>
				
                <div class="card-body">
				<?php if ($eventos) { ?>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col">Nome</th>
								<th scope="col">Data</th>
								<th scope="col">Organizador</th>
								<th scope="col">Detalhes</th>
								<th scope="col">Confirmar Presença</th>
							</tr>
						</thead>
						<tbody>
						@foreach($eventos as $cada)
							<tr>
								<th scope="row">{{$cada->nome_evento}}</th>
								<td>{{$cada->data_inicio}}</td>
								<td>{{$cada->name}}</td>
								
								<td><a class="btn btn-success" href="{{ route('/evento/detalhes', $cada->id) }}"> Detalhes </a></td>
								<td><a class="btn btn-success" href="{{ route('/evento-pessoas/confirmacao', ['evento' => $cada->id, 'user_id' => Auth::user()->id ]) }}"> Confirmar </a></td>
								<!-- <td><a class="btn btn-success" href="{{ route('/eventos/editar', $cada->id) }}"> Editar </a></td>
								<td><a class="btn btn-warning" href="{{ route('/eventos/excluir', $cada->id) }}"> Excluir </a></td> -->
							</tr>
						@endforeach
						</tbody>
					</table>
				<?php } else { ?>
					<p>Não existem novos eventos</p>
				<?php } ?>
				</div>
				
			</div>
		</div>
	</div>
</div>
@endsection