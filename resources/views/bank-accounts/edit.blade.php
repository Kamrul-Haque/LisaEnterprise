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
        <h2>Edit Bank Account</h2>
        <hr>
        <form action="{{route('bank-account.update', $bankAccount)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="bank">Bank Name</label>
                <input type="text" id="bank" name="bank" class="form-control @error('bank') is-invalid @enderror" value="{{ $bankAccount->bank_name }}" required>

                @error('bank')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="branch">Branch</label>
                <input type="text" id="branch" name="branch" class="form-control @error('branch') is-invalid @enderror" value="{{ $bankAccount->branch }}" required>

                @error('branch')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="account_no">Account Number</label>
                <input type="number" name="account_no" id="account_no" class="form-control @error('account_no') is-invalid @enderror" value="{{ $bankAccount->account_no }}" required>

                @error('account_no')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group pb-1">
                <label for="balance">Balance</label>
                <input type="number" name="balance" id="balance" class="form-control @error('balance') is-invalid @enderror" value="{{ $bankAccount->balance }}">

                @error('balance')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{  route('bank-account.index')  }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection
