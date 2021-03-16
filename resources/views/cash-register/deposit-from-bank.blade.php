@extends('layouts.app')
@section('style')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            margin: 0;
        }
        .container{
            width: 500px;
        }
        label{
            font-size: medium;
        }
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
@section('content')
    <div class="container m-auto">
        <h2>Deposit From Bank</h2>
        <hr>
        <form action="{{route('cash-register.deposit.bank.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="account">Account</label>
                <select id="account" name="account" class="form-control @error('account') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach ($bankAccounts as $bankAccount)
                        <option value="{{ $bankAccount->id }}" @if(old('account')==$bankAccount->id) selected @endif>{{ $bankAccount->bank_name }}, {{ $bankAccount->branch }} - {{ $bankAccount->account_no }}</option>
                    @endforeach
                </select>

                @error('account')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="any" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>

                @error('amount')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group pb-1">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>

                @error('date')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <hr>
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('cash-register.index') }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection
