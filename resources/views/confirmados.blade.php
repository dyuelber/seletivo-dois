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

			<a class="btn btn-primary" href="{{ route('/evento/presenca', Auth::user()->id) }}">Voltar</a>

			<div class="card">
                <div class="card-header">
					Eventos Confirmados
				</div>
				
                <div class="card-body">
				<?php if ($eventos) { ?>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col">Nome</th>
								<th scope="col">Data</th>
								<th scope="col">Organizador</th>
								<th scope="col">Cancelar Presença</th>
							</tr>
						</thead>
						<tbody>
						@foreach($eventos as $cada)
							<tr>
								<?php $inicio =  date("d-m-Y H:i:s", strtotime($cada->data_inicio)); ?>
								<th scope="row">{{$cada->nome_evento}}</th>
								<td>{{$inicio}}</td>
								<td>{{$cada->name}}</td>
								
								<td><a class="btn btn-danger" href="{{ route('/evento-pessoas/cancelar', $cada->evento_pessoa_id) }}"> Cancelar </a></td>
								<!-- <td><a class="btn btn-success" href="{{ route('/eventos/editar', $cada->id) }}"> Editar </a></td>
								<td><a class="btn btn-warning" href="{{ route('/eventos/excluir', $cada->id) }}"> Excluir </a></td> -->
							</tr>
						@endforeach
						</tbody>
					</table>
				<?php } else { ?>
					<p>Você não confirmou a presença em nenhum evento</p>
				<?php } ?>
				</div>
				
			</div>
		</div>
	</div>
</div>
@endsection