@extends('layouts.app')
@section('style')
    <style>
        .btn{
            line-height: 200px;
            font-size: xx-large;
            font-weight: bolder;
        }
        a.btn{
            color: whitesmoke;
        }
        a.btn-warning, a.btn-info, a.btn-primary{
            color: black;
        }
        a.btn-warning:hover{
            background-color: gold;
        }
        a.btn-primary:hover, a.btn-info:hover{
            color: black;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid pl-5 pr-5 pt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <a class="btn btn-block btn-lg btn-success" href="{{route('invoices.create')}}">
                        <span data-feather="shopping-cart" style="height: 47px; width: auto; margin-right: 10px"></span>Sell Product
                    </a>
                </div>
                <br>
                <div class="form-group">
                    <a class="btn btn-block btn-lg btn-primary" href="{{route('payments.create')}}">
                        <span data-feather="dollar-sign" style="height: 47px; width: auto; margin-right: 0; padding-right: 0"></span><span data-feather="plus-circle" style="height: 25px; width: auto; margin-left: 0; padding-left: 0; margin-right: 10px; vertical-align: text-top"></span>Add Payment
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <a class="btn btn-block btn-lg btn-info" href="{{route('quotation.print')}}">
                        Print Quotation<span data-feather="printer" style="height: 47px; width: auto; margin-left: 10px"></span>
                    </a>
                </div>
                <br>
                <div class="form-group">
                    <a class="btn btn-block btn-lg btn-warning" href="{{route('clients.create')}}">
                        Add Client<span data-feather="shopping-bag" style="height: 47px; width: auto; margin-left: 10px"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
