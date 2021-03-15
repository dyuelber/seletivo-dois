<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
	<!-- <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>  -->
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	
	<!-- <script>
		const beamsClient = new PusherPushNotifications.Client({
			instanceId: '43bd8e48-8b85-44f4-809d-9797ea925f86',
		});

		beamsClient.start()
			.then(() => beamsClient.addDeviceInterest('hello'))
			.then(() => console.log('Successfully registered and subscribed!'))
			.catch(console.error);
	</script> -->
	<!-- ^ notification -->
	

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
			@guest
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
			@else
				<a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
			@endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
							<div id="not_usuarios">
								<ul>
								@verbatim

								<li id="notification_li" v-if="exibir">
									<span id="notification_count"></span>
									<div id="notificationContainer">
										<div id="notificationTitle">Novo Evento!</div>
										<div id="notificationsBody" v-for="(message, id) in messages">
											<strong>Criado por:</strong> {{ message.user }} <br>
											<strong>Nome:</strong> {{ message.nome }} <br>
											<strong>Data:</strong> {{ message.data }} <br>
										
											<a :href="message.url" > Abrir </a> <br>
											<!-- <a v-on:click="marcar()" href="javascript:void(0)" > Marcar como lido </a> <br> -->
											<hr>
										</div>
										<div id="notificationFooter"> </div>
									</div>
								</li>
								@endverbatim
								</ul>
							</div>
							<li class="nav-item">
                                <a class="nav-link" href="{{ route('/eventos') }}">{{ __('Gerenciar Eventos') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
	<script>
		// Enable pusher logging - don't include this in production
		Pusher.logToConsole = true;

		var pusher = new Pusher('4c13fb1027959f24cb24', {
			cluster: 'us2'
		});

		var channel = pusher.subscribe('teste1');
		channel.bind('not-usuarios', function(data) {
			app.messages.push(data);
			app.exibir = true;
		});

		// Vue application
		const app = new Vue({
			el: '#not_usuarios',
			data: {
				exibir: false,
				messages: [],
			},
			methods: {
				async marcar(not_id) {
					axios.get('/eventos/marcar-como-lido/' + not_id)
						.then((response) => {
						console.log(response.data);
						console.log(response.status);
						console.log(response.statusText);
						console.log(response.headers);
						console.log(response.config);
					});
				},
				// async buscaNotificacoesNaoLidas() {
				// 	axios.get('/eventos/busca-notificacoes-nao-lidas')
				// 		.then(response => (
				// 			$this.exibir = true;
				// 			$this.messages.push(response.data);
				// 			console.log(response.data);
				// 		));
				// 		.catch(error => {
        		// 			console.log(error)
      			// 		});
				// }

			}
		});

		// if (app.exibir === false) {
		// 	app.buscaNotificacoesNaoLidas()
		// }		
  </script>
</body>
</html>
