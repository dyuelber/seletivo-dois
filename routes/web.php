<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// rotas de eventos
Route::get('/eventos', 'EventoController@index')->name('/eventos');
Route::get('/eventos/create', 'EventoController@create')->name('/eventos/adicionar');
Route::post('/eventos', 'EventoController@store')->name('/eventos');
Route::get('/evento/pessoas/{evento}', 'EventoController@show')->name('/evento/pessoas');
Route::get('/evento/presenca/{user_id}', 'EventoController@presenca')->name('/evento/presenca');
Route::get('/evento/detalhes/{evento}', 'EventoController@detalhes')->name('/evento/detalhes');
Route::get('/eventos/editar/{evento}', 'EventoController@edit')->name('/eventos/editar');
Route::post('/eventos/editar/{evento}', 'EventoController@update')->name('/eventos/editar');
Route::get('/eventos/excluir/{evento}', 'EventoController@destroy')->name('/eventos/excluir');

// 
Route::get('/eventos/busca-notificacoes-nao-lidas', 'EventoController@buscaNotificacoesNaoLidas')->name('/eventos/busca-notificacoes-nao-lidas');
Route::get('/eventos/marcar-como-lido/{not_id}', 'EventoController@marcarComoLido')->name('/eventos/marcar-como-lido');

//
Route::get('/evento-pessoas/confirmacao/{evento}/{user_id}', 'EventoPessoasController@store')->name('/evento-pessoas/confirmacao');
Route::get('/evento-pessoas/confirmados/{user_id}', 'EventoPessoasController@confirmados')->name('/evento-pessoas/confirmados');
Route::get('/evento-pessoas/cancelar/{evento_pessoa_id}', 'EventoPessoasController@destroy')->name('/evento-pessoas/cancelar');