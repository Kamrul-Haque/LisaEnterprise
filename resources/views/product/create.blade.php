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
    </style>
@endsection
@section('content')
    <div class="container m-auto">
        <h2>Create Product</h2>
        <hr>
        <form class="form was-validated" id="form" action="{{route('products.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="unit">Unit</label>
                <select name="unit" id="unit" class="form-control" required>
                    <option value="" disabled selected>Please Select...</option>
                    <option value="TON">TON</option>
                    <option value="KG">KG</option>
                    <option value="BAG">BAG</option>
                </select>
            </div>
            <hr>
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection
