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

			<a class="btn btn-primary" href="{{ route('/eventos') }}">Voltar</a>
			<div class="card">
                <div class="card-header">
				<b>Evento:</b> {{ $evento->nome_evento }}
				<p><b>Descrição:</b> {{ $evento->descricao }}</p>
				</div>

                <div class="card-body">
					<p><b>Pessoas confirmadas no evento:</b></p>
					<?php if ($pessoas) { ?>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">Nome</th>
									<th scope="col">Email</th>
								</tr>
							</thead>
							<tbody>
							@foreach($pessoas as $cada)
								<tr>
									<th scope="row">{{$cada->name}}</th>
									<td>{{$cada->email}}</td>	
									<!-- <td><a class="btn btn-success" href="{{ route('/evento/pessoas', $cada->id) }}"> Pessoas </a></td>
									<td><a class="btn btn-success" href="{{ route('/eventos/editar', $cada->id) }}"> Editar </a></td>
									<td><a class="btn btn-warning" href="{{ route('/eventos/excluir', $cada->id) }}"> Excluir </a></td> -->
								</tr>
							@endforeach
							</tbody>
						</table>
					<?php } else { ?>
						<p>Ainda não existe nenhuma confirmação de presença para o evento</p>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection