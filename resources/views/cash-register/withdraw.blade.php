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
        <h2>Withdraw</h2>
        <hr>
        <form id="form" class="form was-validated" action="{{route('admin.cash-register.withdraw.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="any" id="amount" name="amount" class="form-control" required>
            </div>
            <div class="form-group pb-1">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group pb-1">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="5"></textarea>
            </div>
            <div class="form-group pb-1">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <hr>
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection

