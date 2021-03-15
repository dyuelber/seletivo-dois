@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

				

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
						<a class="btn btn-outline-secondary" href="{{ route('/evento/presenca', Auth::user()->id) }}"> Eventos </a>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
