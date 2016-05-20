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
                            <li><a href="{{ url('/send') }}"><i class="fa fa-btn fa-envelope"></i>Enviar mensaje a soporte</a></li>
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
                <li><a href="{{ URL::to('menus/'.$menu->restaurant_id) }} " style="color:white;">Ver los menús</a></li>
            </ul>
        </nav>

        <!-- will be used to show any messages -->
        @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <h2>{{ $menu->name }}</h2>
                </div>
                <div class="col-md-2 pull-right">
                    <button name="newSection" type="button" class="btn btn-success" data-toggle="modal" data-target="#newSection" data-menuid="{{$menu->id}}" style="margin-bottom:-50px;    bottom: 0;
    position: absolute;">
                        Añadir una sección
                    </button>
                </div>
            </div>
            <hr style="border-top: 3px solid #212121; margin-top: 5px;">
            <div class="row">
                @foreach($sections as $key => $value)
                    <div class="col-md-6">
                        <div class="menu-section col-md-12">
                            <div class="row" style="border-bottom:solid 1px #eee;">
                                <div class="col-md-8">
                                    <h4>{{$value->name}}</h4>
                                </div>
                                <div class="col-md-4">
                                    <button name="newElement" type="button" class="btn btn-info add-element" data-toggle="modal" data-target="#newElement" data-sectionid="{{$value->id}}">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                                    </button>
                                    <a class="btn btn-small btn-info" href="#" data-toggle="modal" data-target="#updateSection" data-sectionid="{{$value->id}}" data-name="{{$value->name}}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    {{ Form::open(array('url' => 'sections/' . $value->id, 'class' => 'pull-right')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array('type' => 'submit','class' => 'btn btn-warning')) }}
                                    {{ Form::close() }}
                                </div>
                            </div>

                            @if ($value->elements != null)
                                @foreach($value->elements as $key_element => $value_element)
                                    <div class="menu-element row">
                                        <div class="col-md-6">
                                            <h5>{{$value_element->name}}</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>${{$value_element->price}}</h5>
                                        </div>
                                        <div class="col-md-4" style="    margin-top: 5px;margin-bottom: 5px;">
                                            <button class="btn btn-link btn-small" data-toggle="modal" data-target="#showElement"
                                                    data-elementid="{{$value_element->id}}"
                                                    data-name="{{$value_element->name}}"
                                                    data-price="{{$value_element->price}}"
                                                    data-description="{{$value_element->description}}"
                                                    data-img="{{$value_element->image}}">
                                                <i class="fa fa-eye fa-lg" aria-hidden="true" style="color: #8bc34a;"></i>
                                            </button>
                                            <button class="btn btn-link btn-small" data-toggle="modal" data-target="#updateElement"
                                                    data-elementid="{{$value_element->id}}"
                                                    data-name="{{$value_element->name}}"
                                                    data-price="{{$value_element->price}}"
                                                    data-description="{{$value_element->description}}"
                                                    data-img="{{$value_element->image}}">
                                                <i class="fa fa-pencil fa-lg" aria-hidden="true" style="color:#5bc0de;"></i>
                                            </button>
                                            {{ Form::open(array('url' => 'elements/' . $value_element->id, 'class' => 'pull-right')) }}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::button('<i class="fa fa-trash fa-lg" aria-hidden="true"></i>', array('type' => 'submit','class' => 'btn btn-link btn-small', 'style'=>'color:#f0ad4e')) }}
                                            {{ Form::close() }}

                                        </div>
                                    </div>
                                @endforeach
                            @endif



                        </div>
                    </div>

                @endforeach
            </div>

        </div>



    </div>
</div>

@endsection

<!-- Menu Modal -->
@include('modals/add_section_modal')
@include('modals/edit_section_modal')
<!-- Element Modal -->
@include('modals/add_element_modal')
@include('modals/edit_element_modal')
@include('modals/show_element_modal')
