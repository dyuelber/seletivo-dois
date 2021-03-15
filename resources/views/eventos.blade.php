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

			<a class="btn btn-primary" href="{{ route('home') }}">Home</a>
			<a class="btn btn-primary" href="{{ route('/eventos/adicionar') }}">Adicionar Evento</a>
        	
			<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">Evento</th>
						<th scope="col">Descrição</th>
						<th scope="col">Início</th>
						<th scope="col">Fim</th>
						<th scope="col">Notificação</th>
						<th scope="col">Participantes</th>
						<th scope="col">Editar</th>
						<th scope="col">Excluir</th>
					</tr>
				</thead>
				<tbody>
				@foreach($eventos as $cada)
					<?php 
						$inicio =  date("d-m-Y H:i:s", strtotime($cada->data_inicio)); 
						$fim = $cada->data_fim ? date("d-m-Y H:i:s", strtotime($cada->data_fim)) : '-';
						$notificacao =  date("d-m-Y H:i:s", strtotime($cada->data_notificacao));
					?>
					<tr>
						<th scope="row">{{$cada->nome_evento}}</th>
						<td>{{$cada->descricao}}</td>
						<td>{{$inicio}}</td>
						<td>{{$fim}}</td>
						<td>{{$notificacao}}</td>
						<td><a class="btn btn-success" href="{{ route('/evento/pessoas', $cada->id) }}"> Pessoas </a></td>
						<td><a class="btn btn-warning" href="{{ route('/eventos/editar', $cada->id) }}"> Editar </a></td>
                		<td><a class="btn btn-danger" href="{{ route('/eventos/excluir', $cada->id) }}"> Excluir </a></td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection