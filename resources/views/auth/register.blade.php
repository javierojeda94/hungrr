@extends('layouts.app')

@section('content')
<div class="register-container">
    <div class="black"></div>
    <div class="container centered_child">
        <div class="col-md-6">
            <div class="col-md-12 ">
                <div class="brand-container">
                    <img class="logo-img" src="images/logo.png">
                    <p class="brand-register">Hungrr</p>
                    <p class="slogan">Para saciar al mounstro que llevas dentro</p>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="border-left: 2px solid white;">
            <div class="row">
            <div class="col-md-12">
                <div class="register-form">
                    <p class="panel-heading register">¡Regístrate!</p>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nombre">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Apellido">

                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo Electr&oacute;nico">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="password" class="form-control" name="password" placeholder="Contrase&ntilde;a">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Contrase&ntilde;a">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary register-btn">
                                        Registrarme
                                    </button>
                                </div>
                                <p class="already">¿Ya tienes una cuenta? <a href="{{ url('/login') }}">Inicia sesión</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection
