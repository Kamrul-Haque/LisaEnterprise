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
        <h2>Edit Product - {{$product->name}} </h2>
        <hr>
        <form class="form was-validated" action="{{route('products.update', $product->id)}}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="pname">Product Name</label>
                <input type="text" id="pname" name="pname" class="form-control" value="{{$product->name}}" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" step="any" id="quantity" name="quantity" class="form-control" value="{{$product->quantity}}" required>
            </div>
            <div class="form-group">
                <label for="price">Unit Price</label>
                <input type="number" step="any" id="price" name="price" class="form-control" value="{{$product->unit_buying_price}}" required>
            </div>
            <div class="form-group">
                <label for="unit">Unit</label>
                <select name="unit" id="unit" class="form-control" required>
                    <option value="" selected>Please Select...</option>
                    <option value="TON">TON</option>
                    <option value="KG">KG</option>
                    <option value="BAG">BAG</option>
                </select>
            </div>
            <div class="form-group">
                <label for="godown">Godown</label>
                <select name="godown" id="godown" class="form-control" required>
                    <option value="" selected>Please Select...</option>
                    @foreach ($godowns as $godown)
                        <option value="{{$godown->id}}">{{$godown->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group pb-1">
                <label for="date">Entry Date</label>
                <input type="date" id="date" name="date" class="form-control" value="{{$product->date}}" required>
            </div>
            <div class="form-group">
                <label for="company">Bought From</label>
                <input type="text" id="company" name="company" class="form-control" value="{{$product->bought_from}}" required>
            </div>
            <hr>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection
