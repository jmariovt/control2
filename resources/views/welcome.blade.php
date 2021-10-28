@extends('layouts.app')

@section('content')
    <div class="container">

    <div class="jumbotron">
      <h1 class="display-3">Bienvenido al sistema de control</h1>
      <p class="lead"></p>
      
      
    </div>




            
            <!--
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif-->
    </div>
@endsection


