@extends('layouts.app')
@section('style')
    <style>
        body{
            padding-top: 2%;
            background-color: black;
        }
        #error-code{
            color: red;
            font-size: 5em;
        }
        #error-message{
            color: white;
            font-size: 4em;
        }
        #error-image{
            bottom: 0;
            float: right;
        }
        a{
            text-decoration: none;
            color: whitesmoke;
        }
        a:hover{
            text-decoration: none;
            color: orange;
        }
    </style>
@endsection
@section('content')
    <div class="container text-center">
        <p id="error-code"><i class="fa fa-warning fa"></i>&iexcl;Oh no! &iexcl;404!</p>
        <p id="error-message"> Lo sentimos, nuestros chefs no han podido encontrar lo que estabas buscando. <br>
            <a href="{{url('/home')}}"><span class="fa fa-home"> Ir al inicio. </a></p>
    </div>
    <img id="error-image" class="img img-responsive" src="{{asset('images/background/child_smiling.jpg')}}" alt="Child 404">
@endsection