@extends('layouts.app')
@section('style')
    <style>
        .btn{
            line-height: 120px;
            font-size: xx-large;
            font-weight: bolder;
        }
        .btn-light
        {
            background-color: lightgrey;
        }
        a.btn{
            color: whitesmoke;
        }
        a.btn-warning, a.btn-info, a.btn-primary, a.btn-light, a.btn-aqua{
            color: black;
        }
        a.btn-warning:hover{
            background-color: gold;
        }
        .btn-purple{
            background-color: purple;
        }
        a.btn-purple:hover{
            background-color: darkmagenta;
            color: whitesmoke;
        }
        .btn-aqua{
            background-color: aqua;
        }
        a.btn-aqua:hover{
            background-color: #00E6E6;
        }
        a.btn-primary:hover, a.btn-info:hover{
            color: black;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid pl-5 pr-5">

</div>
@endsection
