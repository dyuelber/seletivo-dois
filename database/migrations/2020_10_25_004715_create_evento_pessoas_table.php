<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventoPessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_pessoas', function (Blueprint $table) {
            $table->id();
			$table->foreignId('evento_id')->constrained('eventos');
			$table->foreignId('user_id')->constrained('users');
			$table->enum('confirmacao', ['Sim', 'Não']);
			$table->dateTime('envio_email', 0)->nullable();
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
        Schema::dropIfExists('evento_pessoas');
    }
}
