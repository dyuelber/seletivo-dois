<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailAvisoEvento extends Mailable
{
    use Queueable, SerializesModels;

	private $dados;

	private $nome_evento;

	private $finalizar;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome_evento, $dados, $finalizar = false)
    {
        //
		$this->dados = $dados;
		$this->nome_evento = $nome_evento;
		$this->finalizar = $finalizar;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		
		$this->dados->finalizar = $this->finalizar;
		
		return $this->from('dyuelbermiranda@gmail.com', 'Novos Eventos')
			->subject($this->nome_evento)
			->view('layout_email')
			->with('dados', $this->dados);

        //return $this->view('view.name');
    }
}
