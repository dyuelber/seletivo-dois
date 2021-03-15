<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = ['user_id','nome_evento','descricao','data_inicio', 'data_fim', 'data_notificacao'];
	
	public function eventoPessoas() {
    	return $this->hasMany('App\EventoPessoas');
  	}
}
