
@if ($dados->finalizar) 
	<h3>Olá {{ $dados->user }}</h3>

	<h4>O evento: {{ $dados->nome }} foi cancelado pelo organizador.</h4>
	
	<p>Acesse o sistema e veja os outros eventos disponíveis.</p>

@else 
	<h3>Olá {{ $dados->user }}</h3>

	<h4>O evento: {{ $dados->nome }} está quase começando, abaixo segue alguns detalhes.</h4>

	<p><strong>Nome:</strong> {{ $dados->nome }}</p>
	<p><strong>Descrição:</strong> {{ $dados->descricao }}</p>
	<p><strong>Início:</strong> {{ $dados->data }}</p>
	<br>
	<p><strong>Organizado por:</strong> {{ $dados->organizador }} </p>
@endif