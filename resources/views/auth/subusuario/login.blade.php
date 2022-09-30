@extends('layouts.app')

@section('content')
@include('common.errors')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top: 25px;">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('extlogin') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="Usuario" class="col-md-4 col-form-label text-md-right">{{ __('Usuario') }}</label>

                            <div class="col-md-6">
                                <!--<input id="Email" type="email" class="form-control @error('Email') is-invalid @enderror" name="Email" value="{{ old('Email') }}" required autocomplete="Email" autofocus>-->
                                <input id="Usuario" type="text" class="form-control @error('Usuario') is-invalid @enderror" value="{{ old('Usuario') }}"  name="Usuario"  required autofocus>
                                @error('Usuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Clave" class="col-md-4 col-form-label text-md-right">{{ __('Clave') }}</label>

                            <div class="col-md-6">
                                <input id="Clave" type="password" class="form-control @error('Clave') is-invalid @enderror" name="Clave" required autocomplete="current-password">

                                @error('Clave')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Aplicacion" class="col-md-4 col-form-label text-md-right">Aplicación</label>
                            <div class="col-md-6">
                                <select class="form-control-sm" id="Aplicacion" name="Aplicacion">
									<option value=37 selected>Monitoreo</option>
									
									
								</select>
                            </div>
                        </div>

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
