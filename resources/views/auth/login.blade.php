@extends('layouts.app')

@section('content')
<div class="login-container">
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
                <div class="login-form">
                    <div class="panel-heading login">Iniciar sesi&oacute;n</div>
                    <div class="panel-body form-horizontal">
                        <form class="form-horizontal login-form" role="form" method="POST" action="{{ url('/login') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"  placeholder="Correo Electrónico">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="password" class="form-control" name="password" placeholder="Contraseña">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label class="remember">
                                            <input type="checkbox" name="remember" > Recu&eacute;rdame
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12" style="text-align:center;">
                                    <button type="submit" class="btn login-btn">
                                        Iniciar Sesi&oacute;n
                                    </button>
                                    <p class="already">¿No tienes una cuenta? <a href="{{ url('/register') }}">¡Regístrate!</a></p>
                                    <a class="btn btn-link forgot-password" href="{{ url('/password/reset') }}">Olvid&eacute; mi contrase&ntilde;a</a>
                                </div>
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
