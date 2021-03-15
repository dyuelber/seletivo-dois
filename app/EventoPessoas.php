<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventoPessoas extends Model
{
	protected $fillable = ['evento_id','user_id','confirmacao','envio_email'];

	// public function pessoas() {
    // 	return $this->hasMany('App\Evento');
  	// }
}
