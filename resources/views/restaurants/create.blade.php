@extends('layouts.app')

@section('content')
<div>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Hungrr
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Mi Inicio</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Inicia Sesi&oacute;n</a></li>
                        <li><a href="{{ url('/register') }}">Regístrate</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Cerrar Sesi&oacute;n</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <nav class="navbar navbar-inverse">
            <ul class="nav navbar-nav">
                <li><a href="{{ URL::to('restaurants') }}">Ver Todos Restaurantes</a></li>
                <li><a href="{{ URL::to('restaurants/create') }}" style="color:white;">Crear un Restaurant</a>
            </ul>
        </nav>
        <!-- if there are creation errors, they will show here -->
        {{ HTML::ul($errors->all()) }}

        {{ Form::open(array('url' => 'restaurants', 'files' => true)) }}

            <div class="panel-body">                 
                <div class="col-md-12 general">
                    <h2>Datos generales</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-8">
                            <span class="col-md-12">
                                {{ Form::text('name', Input::old('name'), array('required','class' => 'form-control', 'placeholder'=>'Nombre del restaurante', 'style'=>'margin-bottom: 10px;')) }}
                            </span>
                            <span class="col-md-12">
                                {{ Form::text('direction', Input::old('direction'), array('required','class' => 'form-control', 'placeholder'=>'Dirección', 'style'=>'margin-bottom: 10px;')) }}
                            </span>
                            <span class="col-md-12">
                                {{ Form::text('phone', Input::old('phone'), array('required','class' => 'form-control', 'placeholder'=>'Teléfono', 'style'=>'margin-bottom: 10px;')) }}
                            </span>
                            <span class="col-md-12">
                                {{ Form::text('type', Input::old('type'), array('required','class' => 'form-control', 'placeholder'=>'Tipo de restaurante Ej. Comida rápida, Pizzería, etc.', 'style'=>'margin-bottom: 10px;')) }}
                            </span>
                            <span class="col-md-12">
                                {!! Form::file('image', array('required','id'=>'imgInp')) !!}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <img id="img_preview" src="../images/placeholder3.png" alt="Preview" style="max-width:250px;max-height: 250px;"/>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-12 opening-hours">
                    <h2>Horario</h2>
                    <hr>
                    <div class="row">
                        <div class="day text-center">
                            <p>Lunes</p>
                            {{ Form::text('monday_oh', Input::old('monday_oh'), array('required','class' => 'form-control', 'placeholder'=>'Inicio', 'style'=>'margin-bottom: 10px;', 'id'=>'monday_oh')) }}
                            {{ Form::text('monday_ch', Input::old('monday_ch'), array('required','class' => 'form-control', 'placeholder'=>'Final', 'style'=>'margin-bottom: 10px;', 'id'=>'monday_ch')) }}
                        </div>
                        <div class="day text-center">
                            <p>Martes</p>
                            {{ Form::text('tuesday_oh', Input::old('tuesday_oh'), array('required','class' => 'form-control', 'placeholder'=>'Inicio', 'style'=>'margin-bottom: 10px;', 'id'=>'tuesday_oh')) }}
                            {{ Form::text('tuesday_ch', Input::old('tuesday_ch'), array('required','class' => 'form-control', 'placeholder'=>'Final', 'style'=>'margin-bottom: 10px;', 'id'=>'tuesday_ch')) }}
                        </div>
                        <div class="day text-center">
                            <p>Miércoles</p>
                            {{ Form::text('wednesday_oh', Input::old('wednesday_oh'), array('required','class' => 'form-control', 'placeholder'=>'Inicio', 'style'=>'margin-bottom: 10px;', 'id'=>'wednesday_oh')) }}
                            {{ Form::text('wednesday_ch', Input::old('wednesday_ch'), array('required','class' => 'form-control', 'placeholder'=>'Final', 'style'=>'margin-bottom: 10px;', 'id'=>'wednesday_ch')) }}
                        </div>
                        <div class="day text-center">
                            <p>Jueves</p>
                            {{ Form::text('thursday_oh', Input::old('thursday_oh'), array('required','class' => 'form-control', 'placeholder'=>'Inicio', 'style'=>'margin-bottom: 10px;', 'id'=>'thursday_oh')) }}
                            {{ Form::text('thursday_ch', Input::old('thursday_ch'), array('required','class' => 'form-control', 'placeholder'=>'Final', 'style'=>'margin-bottom: 10px;', 'id'=>'thursday_ch')) }}
                        </div>
                        <div class="day text-center">
                            <p>Viernes</p>
                            {{ Form::text('friday_oh', Input::old('friday_oh'), array('required','class' => 'form-control', 'placeholder'=>'Inicio', 'style'=>'margin-bottom: 10px;', 'id'=>'friday_oh')) }}
                            {{ Form::text('friday_ch', Input::old('friday_ch'), array('required','class' => 'form-control', 'placeholder'=>'Final', 'style'=>'margin-bottom: 10px;', 'id'=>'friday_ch')) }}
                        </div>

                        <div class="day text-center">
                            <p>Sábado</p>
                            {{ Form::text('saturday_oh', Input::old('saturday_oh'), array('required','class' => 'form-control', 'placeholder'=>'Inicio', 'style'=>'margin-bottom: 10px;', 'id'=>'saturday_oh')) }}
                            {{ Form::text('saturday_ch', Input::old('saturday_ch'), array('required','class' => 'form-control', 'placeholder'=>'Final', 'style'=>'margin-bottom: 10px;', 'id'=>'saturday_ch')) }}
                        </div>
                        <div class="day text-center">
                            <p>Domingo</p>
                            {{ Form::text('sunday_oh', Input::old('sunday_oh'), array('required','class' => 'form-control', 'placeholder'=>'Inicio', 'style'=>'margin-bottom: 10px;', 'id'=>'sunday_oh')) }}
                            {{ Form::text('sunday_ch', Input::old('sunday_ch'), array('required','class' => 'form-control', 'placeholder'=>'Final', 'style'=>'margin-bottom: 10px;', 'id'=>'sunday_ch')) }}
                        </div>
                    </div>

                </div>
                <div class="col-md-12 location">
                    <h2>Ubicación</h2>
                    <hr>
                    <div class="form-horizontal row col-md-12">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="us2-address" width="100%" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                {{ Form::hidden('us2-radius', Input::old('us2-radius'), array('required','class' => 'form-control', 'placeholder'=>'Radius', 'id'=>'us2-radius')) }}
                            </div>
                        </div>
                        <div id="us2" style="width: 100%; height: 400px;"></div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="m-t-small">
                            <div class="col-sm-1">
                                {{ Form::hidden('us2-lat', Input::old('us2-lat'), array('required','class' => 'form-control', 'placeholder'=>'Latitud', 'id'=>'us2-lat')) }}
                            </div>
                            <div class="col-sm-1">
                                {{ Form::hidden('us2-lon', Input::old('us2-lon'), array('required','class' => 'form-control', 'placeholder'=>'Longitud', 'id'=>'us2-lon')) }}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="panel-footer row">
                <div class="pull-right">
                    {{ Form::submit('Guardar', array('class' => 'btn btn-lg btn-primary')) }}
                    <a href="{{ URL::to('restaurants') }}" class="btn btn-lg btn-danger">Cancelar</a>
                </div>
            </div>


                {{ Form::close() }}


            </div>
    </div>

    @endsection


</div>


            
