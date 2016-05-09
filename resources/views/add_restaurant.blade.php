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
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Añadir un restaurante</div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    {!! Form::open(array('route' => 'contact_store', 'class' => 'form-restaurant')) !!}

                        <div class="panel-body">
                            
                                <div class="col-md-12 general">
                                    <h2>Datos generales</h2>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span class="col-md-12">
                                                {!! Form::label('<i class="fa fa-home" aria-hidden="true">') !!}
                                                {!! Form::text('name', null, 
                                                    array('required', 
                                                          'class'=>'general', 
                                                          'placeholder'=>'Nombre del restaurante')) !!}
                                            </span>
                                            <span class="col-md-12">
                                                <label><i class="fa fa-map-signs" aria-hidden="true"></i></label>
                                                <input type="text" name="address" placeholder="Dirección" style="width:80%">
                                            </span>
                                            <span class="col-md-12">
                                                <label><i class="fa fa-phone" aria-hidden="true"></i></label>
                                                <input type="tel" name="phone" placeholder="Teléfono" style="width:80%">
                                            </span>
                                            <span class="col-md-12">
                                                <label><i class="fa fa-phone" aria-hidden="true"></i></label>
                                                <input type="text" name="type" placeholder="Tipo de restaurante Ej. Comida rápida, Pizzería, etc." style="width:80%">
                                            </span>
                                            <span class="col-md-12">
                                                <label><i class="fa fa-image" aria-hidden="true"></i></label>
                                                <input type='file' id="imgInp" style="display: inline-block;" />
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <img id="img_preview" src="#" alt="Preview" style="width:250px;"/>
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
                                <div class="col-md-12 menu">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h2>Menú</h2>
                                        </div>
                                        <div class="col-md-2 pull-right">
                                            <button name="newSection" type="button" class="btn btn-info" data-toggle="modal" data-target="#newSection" style="margin-bottom:-50px;">
                                                Añadir una sección</button>
                                        </div>
                                    </div>
                                    <hr style="margin-top:0;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="menu-section col-md-12">
                                                <div class="row" style="border-bottom:solid 1px #eee;">
                                                    <div class="col-md-10">
                                                        <h4>Nombre de la sección</h4>
                                                    </div>
                                                    <div class="col-md-2  pull-right">
                                                        <button name="newElement" type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#newElement" style="margin-bottom:-50px;">
                                                + elemento</button>
                                                    </div> 
                                                </div>
                                                <div class="menu-element row">
                                                    <div class="col-md-10">
                                                        <h5>Nombre del elemento</h5>
                                                    </div>
                                                    <div class="col-md-2  pull-right">
                                                        $100
                                                    </div>
                                                </div>
                                                <div class="menu-element row">
                                                    <div class="col-md-10">
                                                        <h5>Nombre del elemento</h5>
                                                    </div>
                                                    <div class="col-md-2  pull-right">
                                                        $100
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="menu-section col-md-12">
                                                <div class="row" style="border-bottom:solid 1px #eee;">
                                                    <div class="col-md-10">
                                                        <h4>Nombre de la sección</h4>
                                                    </div>
                                                    <div class="col-md-2  pull-right">
                                                        <button name="newElement" type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#newElement" style="margin-bottom:-50px;">
                                                            + elemento</button>
                                                    </div> 
                                                </div>
                                                <div class="menu-element row">
                                                    <div class="col-md-10">
                                                        <h5>Nombre del elemento</h5>
                                                    </div>
                                                    <div class="col-md-2  pull-right">
                                                        $100
                                                    </div>
                                                </div>
                                                <div class="menu-element row">
                                                    <div class="col-md-10">
                                                        <h5>Nombre del elemento</h5>
                                                    </div>
                                                    <div class="col-md-2  pull-right">
                                                        $100
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            
                            

                        </div>
                        <div class="panel-footer">
                            <div style="text-align: right;">
                                <button type="button" class="btn btn-default btn-lg btn-primary">Guardar</button>
                                <button type="button" class="btn btn-default btn-lg  btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div> 
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Modal -->
@include('modals/add_section_modal')
<!-- Element Modal -->
@include('modals/add_element_modal')

@endsection
