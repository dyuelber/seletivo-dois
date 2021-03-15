<?php

namespace App\Http\Controllers;

use App\Evento;
use App\User;
use App\Mail\EmailAvisoEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\AvisoEvento;
use Illuminate\Support\Facades\Notification;
use Illuminate\Suppot\Facades\Mail;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$eventos = Evento::where('user_id', auth()->user()->id)->get();

        return view('eventos', ['eventos' => $eventos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {	

		// $pessoas = DB::select(
		// 		"SELECT ep.id, e.nome_evento as nome, e.descricao, date_format(e.data_inicio, '%d/%m/%Y %H:%i') as data, 
		// 		users.email, users.name as user, organizador.name as organizador
		// 		FROM evento_pessoas as ep 
		// 		INNER JOIN users ON ep.user_id = users.id 
		// 		INNER JOIN eventos as e ON ep.evento_id = e.id
		// 		INNER JOIN (
		// 			SELECT users.id, users.name, users.email
		// 			FROM eventos as ev
		// 			INNER JOIN users ON ev.user_id = users.id
		// 		) as organizador ON e.user_id = organizador.id
		// 		WHERE ep.envio_email IS NULL
		// 		AND e.data_notificacao <= now()"
		// 	);

		// 	foreach ($pessoas as $cada_pessoa) {
		// 		\Mail::to($cada_pessoa->email)
		// 			->send(new EmailAvisoEvento($cada_pessoa->nome .' - '. $cada_pessoa->data, $cada_pessoa));
				
		// 		// atualizo o campo de controle de email
		// 		$update = DB::table('evento_pessoas')
        //       		->where('id', $cada_pessoa->id)
        //       		->update(['envio_email' => date('Y-m-d H:i:s')]);
		// 	}

		// // teste de email
		// $email = 'miranda.aparecida.rodrigues@gmail.com';
		// $dados['user'] = 'Maria Aparecida';
		// $dados['nome'] = 'Teste de envio de email ';
		// $dados['descricao'] = 'Teste';
		// $dados['data'] = '2021-03-14';
		// $dados['organizador'] = 'Dyuelber';

		// \Mail::to($email)->send(new EmailAvisoEvento($dados['nome'].'2021-03-14', $dados));
		// teste de email

        //
		// $options = array(
		// 	'cluster' => 'us2',
		// 	'useTLS' => true
		// );
		// $pusher = new \Pusher\Pusher(
		// 	'4c13fb1027959f24cb24',
		// 	'd13275659e5624af6f85',
		// 	'1171022',
		// 	$options
		// );

		// $data['user'] = auth()->user()->name;
		// $data['nome'] =  'Primeiro Teste com notificação';
		// $data['data'] =  '2020-01-10';
		// $data['url'] =  '/evento/detalhes/12';
		// $pusher->trigger('teste1', 'not-usuarios', $data);

		return view('adicionar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		$evento = new Evento();
        $evento->user_id = $request->user_id;
        $evento->nome_evento = $request->nome_evento;
        $evento->descricao = $request->descricao;
        $evento->data_inicio = $request->data_inicio;
		$evento->data_fim = $request->data_fim;
		$evento->data_notificacao = $request->data_notificacao;
		$evento->save();
		$evento_id = $evento->id;

		$evento_pessoas = new \App\EventoPessoas();
		$evento_pessoas->confirmacao = 'Sim';
		$evento_pessoas->user_id = $request->user_id;
		$evento_pessoas->envio_email = date('Y-m-d H:i:s');
		$evento->eventoPessoas()->save($evento_pessoas);

		$users = User::all();
		$data['user'] = auth()->user()->name;
		$data['nome'] =  $evento->nome_evento;
		$data['data'] =  $evento->data_inicio;
		$data['url'] =  '/evento/detalhes/' . $evento_id;

		Notification::send($users, new AvisoEvento($data));
		
		$options = array(
			'cluster' => 'us2',
			'useTLS' => true
		);
		$pusher = new \Pusher\Pusher(
			'4c13fb1027959f24cb24',
			'd13275659e5624af6f85',
			'1171022',
			$options
		);
		$pusher->trigger('teste1', 'not-usuarios', $data);
		
		//$users->notify(new AvisoEvento($request->user_id));

        return redirect()->route('/eventos')->with('status', 'Evento Criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        //
		$evento = Evento::find($evento->id);
		
		$pessoas = DB::select(
			'SELECT ep.*, users.name, users.email 
			FROM evento_pessoas as ep 
			INNER JOIN users ON ep.user_id = users.id 
			WHERE ep.evento_id = ?', [$evento->id]
		);

		return view('evento-pessoas', ['pessoas' => $pessoas], ['evento' => $evento]);
    }

	/**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function presenca($user_id)
    {

		$eventos = DB::select(
			'SELECT e.id, e.nome_evento, date_format(e.data_inicio, "%d-%m-%Y %H:%i:%s") as data_inicio, 
			users.name
			FROM eventos as e
			INNER JOIN users ON e.user_id = users.id
			WHERE e.id NOT IN(
				SELECT ep.evento_id 
				FROM evento_pessoas as ep
				WHERE ep.user_id = ?
			)
			ORDER BY e.data_inicio ASC', [$user_id]
		);
		
		return view('presenca', ['eventos' => $eventos]);
    }

	/**
     * Show the form for detail the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function detalhes(Evento $evento)
    {
        //
		$evento = Evento::find($evento->id);
		
		$evento->data_inicio =  date("d-m-Y H:i:s", strtotime($evento->data_inicio));
		$evento->data_fim = $evento->data_fim ? date("d-m-Y H:i:s", strtotime($evento->data_fim)) : '-';
		$evento->data_notificacao =  date("d-m-Y H:i:s", strtotime($evento->data_notificacao));

		return view('detalhe', ['evento' => $evento]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento)
    {
        //
		$evento = Evento::find($evento->id);
		
		$evento->data_inicio =  date("Y-m-d\TH:i:s", strtotime($evento->data_inicio));
		$evento->data_fim = $evento->data_fim ? date("Y-m-d\TH:i:s", strtotime($evento->data_fim)) : null;
		$evento->data_notificacao =  date("Y-m-d\TH:i:s", strtotime($evento->data_notificacao));

		return view('editar', ['evento' => $evento]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        //
        $evento->user_id = $request->user_id;
        $evento->nome_evento = $request->nome_evento;
        $evento->descricao = $request->descricao;
        $evento->data_inicio = $request->data_inicio;
		$evento->data_fim = $request->data_fim;
		$evento->data_notificacao = $request->data_notificacao;
        $evento->save();
        return redirect()->route('/eventos')->with('status', 'Evento editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        //
		$evento = Evento::find($evento->id);
        $evento->delete();
        return redirect()->route('/eventos')->with('status','Evento excluido com sucesso!');
    }

	public function marcarComoLido($not_id) {
		

	}

	public function buscaNotificacoesNaoLidas() {
		$user = \App\User::find(auth()->user()->id);
		$not = [];
		foreach ($user->unreadNotifications  as $notification) {
			$not[] = $notification->data;
    		// $notification->id; // id da notificacao no bd
			//echo $notification->data;
		}
		return $not;
	}
}
