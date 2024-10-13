@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 p-0 m-0">
                                <a href="{{ route('dashboard') }}" class="box">Dashboard</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 p-0 m-0">
                            <a href="{{ route('event.index') }}" class="box">Event</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 p-0 m-0">
                            <a href="{{ route('email.index') }}" class="box">Recipient Email</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 p-0 m-0">
                            <a href="#" id="sync-now" class="box">Sync Now <i class="fa fa-spin"></i></a>
                            </div>
                            
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('sync-now').addEventListener('click', function() {
        if (navigator.onLine) {
            syncOfflineData();
            window.location.reload()
        } else {
            alert("You are currently offline. Please try again when online.");
        }
    });
</script>
@endsection


