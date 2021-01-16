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
        <h2>Transfer Product</h2>
        <hr>
        <form class="form was-validated" action="{{ route('admin.entries.transfer.store') }}" method="POST">
            @csrf
            <input type="text" name="product" value="{{ $product->id }}" hidden>
            <input type="text" name="godown" value="{{ $godown->id }}" hidden>
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" readonly>
            </div>
            <div class="form-group">
                <label for="cgodown">Current Godown</label>
                <input name="cgodown" id="cgodown" class="form-control" value="{{ $godown->name }}" readonly>
            </div>
            <div class="form-group">
                <label for="tgodown">Transfer To</label>
                <select name="tgodown" id="tgodown" class="form-control" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach ($godowns as $godownz)
                        @if($godown_new->name != $godown->name)
                        <option value="{{$godown_new->id}}">{{$godown_new->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="cquantity">Current Quantity</label>
                <input type="number" step="any" id="cquantity" name="cquantity" class="form-control" value="{{ $product->godowns->find($godown)->pivot->godown_quantity }}" readonly>
            </div>
            <div class="form-group">
                <label for="quantity">Transfer Quantity</label>
                <input type="number" step="any" id="quantity" name="quantity" class="form-control" required>
            </div>
            <div class="form-group pb-1">
                <label for="date">Entry Date</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Transfer</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection
