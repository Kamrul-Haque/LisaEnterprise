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
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <a class="btn btn-block btn-lg btn-light" href="{{route('admin.cash-register.withdraw')}}">
                    <span data-feather="inbox" style="height: 47px; width: auto; margin-right: 0; padding-right: 0"></span><span data-feather="minus-circle" style="height: 25px; width: auto; margin-left: 0; padding-left: 0; margin-right: 10px; vertical-align: text-top"></span>Cash Withdrawal
                </a>
            </div>
            <br>
            <div class="form-group">
                <a class="btn btn-block btn-lg btn-success" href="{{route('invoices.create')}}">
                    <span data-feather="shopping-cart" style="height: 47px; width: auto; margin-right: 10px"></span>Sell Product
                </a>
            </div>
            <br>
            <div class="form-group">
                <a class="btn btn-block btn-lg btn-warning" href="{{route('clients.create')}}">
                    <span data-feather="shopping-bag" style="height: 47px; width: auto; margin-right: 10px"></span>Add Client
                </a>
            </div>
            <br>
            <div class="form-group">
                <a class="btn btn-block btn-lg btn-danger" href="{{route('admin.accounts.create')}}">
                    <span data-feather="user-plus" style="height: 47px; width: auto; margin-right: 10px"></span>Create Admin
                </a>
            </div>
            <br>
            <div class="form-group">
                <a class="btn btn-block btn-lg btn-aqua" href="{{route('payments.create')}}">
                    <span data-feather="dollar-sign" style="height: 47px; width: auto; margin-right: 0; padding-right: 0"></span><span data-feather="plus-circle" style="height: 25px; width: auto; margin-left: 0; padding-left: 0; margin-right: 10px; vertical-align: text-top"></span>Add Payment
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <a class="btn btn-block btn-lg btn-dark" href="{{route('admin.cash-register.deposit')}}">
                    Cash Deposit<span data-feather="inbox" style="height: 47px; width: auto; margin-right:0; padding-right: 0; margin-left: 10px"></span><span data-feather="plus-circle" style="height: 25px; width: auto; margin-left: 0; padding-left: 0; margin-right: 10px; vertical-align: text-top"></span>
                </a>
            </div>
            <br>
            <div class="form-group">
                <a class="btn btn-block btn-lg btn-primary" href="{{route('admin.entries.create')}}">
                    Entry Product<span data-feather="check-square" style="height: 47px; width: auto; margin-left: 10px"></span>
                </a>
            </div>
            <br>
            <div class="form-group">
                <a class="btn btn-block btn-lg btn-secondary" href="{{route('godowns.create')}}">
                    Add Godown<span data-feather="archive" style="height: 47px; width: auto; margin-left: 10px"></span>
                </a>
            </div>
            <br>
            <div class="form-group">
                <a class="btn btn-block btn-lg btn-info" href="{{route('admin.users.create')}}">
                    Add Employee<span data-feather="user-check" style="height: 47px; width: auto; margin-left: 10px"></span>
                </a>
            </div>
            <br>
            <div class="form-group">
                <a class="btn btn-block btn-lg btn-purple" href="{{route('quotation.print')}}">
                    Print Quotation<span data-feather="printer" style="height: 47px; width: auto; margin-left: 10px"></span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
