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
        <h2>Deposit</h2>
        <hr>
        <form id="form" action="{{route('cash-register.deposit.store')}}" method="POST">
            @csrf
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
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>

                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group pb-1">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description') }} </textarea>

                @error('description')
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
            <button type="submit" class="btn btn-info">Deposit</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection

