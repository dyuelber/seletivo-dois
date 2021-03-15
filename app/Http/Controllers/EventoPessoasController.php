<?php

namespace App\Http\Controllers;

use App\EventoPessoas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Suppot\Facades\Mail;
use App\Mail\EmailAvisoEvento;

class EventoPessoasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $evento_id, $user_id)
    {
        //
		$eventoPessoas = new EventoPessoas();
        $eventoPessoas->user_id = $user_id;
		$eventoPessoas->evento_id = $evento_id;
		$eventoPessoas->confirmacao = 'Sim';
		$eventoPessoas->save();

		return redirect()->route('/evento/presenca', $user_id)->with('status', 'Presença no evento confirmada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventoPessoas  $eventoPessoas
     * @return \Illuminate\Http\Response
     */
    public function show(EventoPessoas $eventoPessoas)
    {
        //
		$eventos = new \App\Evento();
		$evento = $eventos->find($eventoPessoas->id);
		
		$eventoPessoas = EventoPessoas::find($eventoPessoas->evento_id);
		return view('evento-pessoas', ['eventoPessoas' => $eventoPessoas, 'evento', $evento]);
    }

	/**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function confirmados($user_id)
    {

		$eventos = DB::select(
			"SELECT e.id, ep.id as evento_pessoa_id, e.nome_evento, e.data_inicio, users.name
			FROM eventos as e
			INNER JOIN users ON e.user_id = users.id
			INNER JOIN evento_pessoas as ep ON e.id = ep.evento_id
			WHERE ep.user_id = ?
			ORDER BY e.data_inicio ASC", [$user_id]
		);
		
		return view('confirmados', ['eventos' => $eventos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventoPessoas  $eventoPessoas
     * @return \Illuminate\Http\Response
     */
    public function edit(EventoPessoas $eventoPessoas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventoPessoas  $eventoPessoas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventoPessoas $eventoPessoas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventoPessoas  $eventoPessoas
     * @return \Illuminate\Http\Response
     */
    public function destroy($evento_pessoa_id)
    {
        //
		// echo 'Terminar e notificar os usuários';
		// die();
		$eventoPessoas = EventoPessoas::find($evento_pessoa_id);
		
		// se o usuario for o criador do evento buscas todas as pessoas que confirmarao presenca para ser avisada
		$user = DB::select(
			"SELECT * FROM eventos 
			WHERE user_id = ? 
			AND id = ?", [auth()->user()->id, $eventoPessoas->evento_id]
		);
		if ($user) {
			$pessoas = DB::select(
				"SELECT ep.id, e.nome_evento as nome, e.descricao, date_format(e.data_inicio, '%d/%m/%Y %H:%i') as data, users.name as user, users.email
				FROM evento_pessoas as ep
				INNER JOIN eventos as e ON ep.evento_id = e.id
				INNER JOIN users ON ep.user_id = users.id
				WHERE ep.evento_id = ?
				AND e.user_id != ep.user_id", [$eventoPessoas->evento_id]
			);

			DB::table('evento_pessoas')->where('evento_id', '=', $eventoPessoas->evento_id)->delete();
			DB::table('eventos')->where('id', '=', $eventoPessoas->evento_id)->delete();

			foreach ($pessoas as $cada_pessoa) {
				\Mail::to($cada_pessoa->email)
					->send(new EmailAvisoEvento($cada_pessoa->nome .' - '. $cada_pessoa->data, $cada_pessoa, true));
			}
			return redirect()->route('/evento-pessoas/confirmados', auth()->user()->id)->with('status','Presença e evento excluidos com sucesso! Os participantes foram notificados"');
		}
        $eventoPessoas->delete();

        return redirect()->route('/evento-pessoas/confirmados', auth()->user()->id)->with('status','Presença no evento excluida com sucesso!');


    }
}
