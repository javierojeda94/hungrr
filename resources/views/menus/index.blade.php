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
                <li><a href="{{ URL::to('menus') }} " style="color:white;">Ver los menús</a></li>
                <li><a href="#"  data-toggle="modal" data-target="#newMenu" data-restaurantid="{{$restaurant->id}}">Crear un menú</a>
            </ul>
        </nav>

        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td style="width: 85%">Nombre</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            @foreach($menus as $key => $value)
                <tr>
                    <td>{{ $value->name }}</td>

                    <!-- we will also add show, edit, and delete buttons -->
                    <td>
                        {{ Form::open(array('url' => 'menus/' . $value->id, 'class' => 'pull-right')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array('type' => 'submit','class' => 'btn btn-warning')) }}
                        {{ Form::close() }}

                        <a class="btn btn-small btn-success" href="{{ URL::to('menus/' . $value->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>

                        <a class="btn btn-small btn-info" href="#" data-toggle="modal" data-target="#updateMenu" data-menuid="{{$value->id}}" data-name="{{$value->name}}">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection

<!-- Menu Modal -->
@include('modals/add_menu_modal')
@include('modals/edit_menu_modal')
