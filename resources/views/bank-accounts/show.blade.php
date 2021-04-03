@extends('layouts.app')
@section('style')
    <style>
        html, body, th {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            margin: 0;
        }
    </style>
    @if(Auth::guard('admin')->check())
        <style>
            th{
                background-color: #23272b;
                color: whitesmoke;
            }
        </style>
    @else
        <style>
            th{
                background-color: #3490dc;
                color: whitesmoke;
            }
        </style>
    @endif
@endsection
@section('content')
    <div class="container-fluid pl-5 pr-5">
        <div class="form-group pb-0">
            <a class="btn btn-light float-left" href=" {{route('bank-account.index')}} ">Back</a>
            <h2 class="text-center">Bank Account Details</h2>
        </div>
        <hr>
        <h5>Bank Name: {{ $bankAccount->bank_name }}</h5>
        <h5>Branch: {{ $bankAccount->branch }}</h5>
        <h5>Account Number: {{ $bankAccount->account_no}}</h5>
        <br>
        <h4>Deposits</h4>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                @component('layouts.components.bank-deposit-table', ['bankDeposits'=>$bankDeposits])
                    deposit
                @endcomponent
            </div>
        </div>
        <br>
        <h4>Withdraws</h4>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                @component('layouts.components.bank-withdraw-table', ['bankWithdraws'=>$bankWithdraws])
                    withdraw
                @endcomponent
            </div>
        </div>
    </div>
@endsection
