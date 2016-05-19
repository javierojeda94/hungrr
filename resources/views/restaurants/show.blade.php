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
                    <a class="navbar-brand" href="#">
                        Hungrr
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->


                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Inicia Sesi&oacute;n</a></li>
                            <li><a href="{{ url('/register') }}">Regístrate</a></li>
                        @else
                            <ul class="nav navbar-nav">
                                <li><a href="{{ url('/home') }}">Mi Inicio</a></li>
                            </ul>
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
                    <li><a href="{{ url('menus/'.$restaurant->id) }}">Ver menús</a></li>
                </ul>
            </nav>
            <div class="panel-body">
                <h1 style="color:#ff5252">{{ $restaurant->name }}</h1>
                <hr style="border-top: 3px solid #ff5252;">
                <div class="col-md-12 general">
                    <h2>Datos generales</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-8">
                            <span class="col-md-12">
                                <label>Dirección: </label> {{$restaurant->direction}}
                            </span>
                            <span class="col-md-12">
                                <label>Teléfono: </label> {{$phones->phone}}
                            </span>
                            <span class="col-md-12">
                                <label>Tipo: </label> {{$restaurant->type}}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <img id="img_preview" src="{{$restaurant->image}}" alt="Preview" style="max-width:250px;max-height: 250px;"/>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 opening-hours">
                    <h2>Horario</h2>
                    <hr>
                    <div class="row">
                        <div class="day text-center">
                            <p>Lunes</p>
                            <label>Inicio: </label> {{$schedules[0]->hour_init}}<br>
                            <label>Cierre: </label> {{$schedules[0]->hour_finish}}
                        </div>
                        <div class="day text-center">
                            <p>Martes</p>
                            <label>Inicio: </label> {{$schedules[1]->hour_init}}<br>
                            <label>Cierre: </label> {{$schedules[1]->hour_finish}}
                        </div>
                        <div class="day text-center">
                            <p>Miércoles</p>
                            <label>Inicio: </label> {{$schedules[2]->hour_init}}<br>
                            <label>Cierre: </label> {{$schedules[2]->hour_finish}}
                        </div>
                        <div class="day text-center">
                            <p>Jueves</p>
                            <label>Inicio: </label> {{$schedules[3]->hour_init}}<br>
                            <label>Cierre: </label> {{$schedules[3]->hour_finish}}
                        </div>
                        <div class="day text-center">
                            <p>Viernes</p>
                            <label>Inicio: </label> {{$schedules[4]->hour_init}}<br>
                            <label>Cierre: </label> {{$schedules[4]->hour_finish}}
                        </div>

                        <div class="day text-center">
                            <p>Sábado</p>
                            <label>Inicio: </label> {{$schedules[5]->hour_init}}<br>
                            <label>Cierre: </label> {{$schedules[5]->hour_finish}}
                        </div>
                        <div class="day text-center">
                            <p>Domingo</p>
                            <label>Inicio: </label> {{$schedules[6]->hour_init}}<br>
                            <label>Cierre: </label> {{$schedules[6]->hour_finish}}
                        </div>
                    </div>

                </div>
                <div class="col-md-12 location">
                    <h2>Ubicación</h2>
                    <hr>
                    <div class="form-horizontal row col-md-12">
                        <div id="us3" style="width: 100%; height: 400px;"></div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="m-t-small">
                            <div class="col-sm-1">
                                <input type="hidden" value="{{$restaurant->latitude}}" class="form-control" style="width: 110px" id="us3-lat" />
                            </div>
                            <div class="col-sm-1">
                                <input type="hidden" value="{{$restaurant->longitude}}" class="form-control" style="width: 110px" id="us3-lon" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection





