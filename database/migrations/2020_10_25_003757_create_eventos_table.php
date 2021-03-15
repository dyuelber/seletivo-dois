<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_id')->constrained('users');
			$table->string('nome_evento');
			$table->string('descricao');
			$table->dateTime('data_inicio', 0);
			$table->dateTime('data_fim', 0)->nullable();
			$table->datetime('data_notificacao', 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
