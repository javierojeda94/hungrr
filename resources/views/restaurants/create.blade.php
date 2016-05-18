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
                        <div class="col-md-2">
                            <span>Lunes</span><br>
                            <input type="hidden" name="day" value="monday">
                            <input id='monday_oh' type='text' name='monday_oh'/>
                            <br>a <br>
                            <input id='monday_ch' type='text' name='monday_ch'/>
                        </div>
                        <div class="col-md-2">
                            <span>Martes</span><br>
                            <input type="hidden" name="day" value="tuesday">
                            <input id='tuesday_oh' type='text'name='tuesday_oh'/>
                            <br>a <br>
                            <input id='tuesday_ch' type='text'name='tuesday_ch'/>
                        </div>
                        <div class="col-md-2">
                            <span>Miércoles</span><br>
                            <input type="hidden" name="day" value="wednesday">
                            <input id='wednesday_oh' type='text'name='wednesday_oh'/>
                            <br>a <br>
                            <input id='wednesday_ch' type='text'name='wednesday_ch'/>
                        </div>
                        <div class="col-md-2">
                            <span>Jueves</span><br>
                            <input type="hidden" name="day" value="thursday">
                            <input id='thursday_oh' type='text'name='thursday_oh'/>
                            <br>a <br>
                            <input id='thursday_ch' type='text'name='thursday_ch'/>
                        </div>
                        <div class="col-md-2">
                            <span>Viernes</span><br>
                            <input type="hidden" name="day" value="friday">
                            <input id='friday_oh' type='text'name='friday_oh'/>
                            <br>a <br>
                            <input id='friday_ch' type='text'name='friday_ch'/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <span>Sábado</span><br>
                            <input type="hidden" name="day" value="saturday">
                            <input id='saturday_oh' type='text'name='saturday_oh'/>
                            <br>a <br>
                            <input id='saturday_ch' type='text'name='saturday_ch'/>
                        </div>
                        <div class="col-md-2">
                            <span>Domingo</span><br>
                            <input type="hidden" name="day" value="sunday">
                            <input id='sunday_oh' type='text'name='sunday_oh'/>
                            <br>a <br>
                            <input id='sunday_ch' type='text'name='sunday_ch'/>
                        </div>
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
