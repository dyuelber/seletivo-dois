<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\DB;
use Illuminate\Suppot\Facades\Mail;
use App\Mail\EmailAvisoEvento;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		// envio de emails
		$schedule->call(function () {
			$pessoas = DB::select(
				"SELECT ep.id, e.nome_evento as nome, e.descricao, date_format(e.data_inicio, '%d/%m/%Y %H:%i') as data, 
				users.email, users.name as user, organizador.name as organizador
				FROM evento_pessoas as ep 
				INNER JOIN users ON ep.user_id = users.id 
				INNER JOIN eventos as e ON ep.evento_id = e.id
				INNER JOIN (
					SELECT users.id, users.name, users.email
					FROM eventos as ev
					INNER JOIN users ON ev.user_id = users.id
				) as organizador ON e.user_id = organizador.id
				WHERE ep.envio_email IS NULL
				AND e.data_notificacao <= now()"
			);

			foreach ($pessoas as $cada_pessoa) {
				\Mail::to($cada_pessoa->email)
					->send(new EmailAvisoEvento($cada_pessoa->nome .' - '. $cada_pessoa->data, $cada_pessoa));
				
				// atualizo o campo de controle de email
				$update = DB::table('evento_pessoas')
              		->where('id', $cada_pessoa->id)
              		->update(['envio_email' => date('Y-m-d H:i:s')]);
			}
		})->everyTwoMinutes(); // a cada dois minutos

        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
