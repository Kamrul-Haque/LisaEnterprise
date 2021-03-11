@extends('layouts.app')
@section('style')
    <style>
        .card-body{
           height: 150px;
        }
        .display-4{
            padding-top: 15px;
            font-size: 40px;
            font-weight: bold;
        }
        .bg-red{
            background-color: darkred;
        }
        .bg-green{
            background-color: seagreen;
        }
        .bg-orange{
            background-color: orange;
        }
        .bg-cyan{
            background-color: cyan;
        }
        .bg-darkCyan{
            background-color: #00c8c8;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid pl-5 pr-5">
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body bg-info shadow-lg">
                    <div class="row">
                        <h3 class="display-4 col-md-6">Sales:</h3>
                        <span class="display-4 text-right col-md-6">{{ $salesToday }} &#2547;</span>
                    </div>
                </div>
                <div class="card-footer bg-primary">
                    <div class="text-center">
                        <h4 class="text-light">Today</h4>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="card">
                <div class="card-body bg-success shadow-lg">
                    <div class="row">
                        <h3 class="display-4 col-md-6">Cash:</h3>
                        <span class="display-4 text-right col-md-6">{{ $cashBalance }} &#2547;</span>
                    </div>
                </div>
                <div class="card-footer bg-green">
                    <div class="text-center">
                        <h4 class="text-light">Balance</h4>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="card">
                <div class="card-body bg-cyan shadow-lg">
                    <div class="row">
                        <h3 class="display-4 col-md-6">Clients:</h3>
                        <span class="display-4 text-right col-md-6">{{ $newClients }}</span>
                    </div>
                </div>
                <div class="card-footer bg-darkCyan">
                    <div class="text-center">
                        <h4 class="text-light">New Today</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body bg-secondary shadow-lg">
                    <div class="row">
                        <h3 class="display-4 col-md-6 text-light">Entries:</h3>
                        <span class="display-4 text-right col-md-6 text-light">{{ $entriesToday }} &#2547;</span>
                    </div>
                </div>
                <div class="card-footer bg-dark">
                    <div class="text-center">
                        <h4 class="text-light">Today</h4>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="card">
                <div class="card-body bg-danger shadow-lg">
                    <div class="row">
                        <h3 class="display-4 col-md-6 text-light">Bank:</h3>
                        <span class="display-4 text-right col-md-6 text-light">{{ $bankBalance }} &#2547;</span>
                    </div>
                </div>
                <div class="card-footer bg-red">
                    <div class="text-center">
                        <h4 class="text-light">Balance</h4>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="card">
                <div class="card-body bg-warning shadow-lg">
                    <div class="row">
                        <h3 class="display-4 col-md-6">Suppliers:</h3>
                        <span class="display-4 text-right col-md-6">{{ $newSuppliers }}</span>
                    </div>
                </div>
                <div class="card-footer bg-orange">
                    <div class="text-center">
                        <h4 class="text-light">New Today</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
