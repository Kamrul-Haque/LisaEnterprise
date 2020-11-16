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
        <h2>Entry Product</h2>
        <hr>
        <form action="{{route('admin.entries.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <select id="name" name="name" class="form-control @error('name') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach ($products as $product)
                        <option value="{{$product->id}}" @if(old('name')==$product->id) selected @endif>{{$product->name}}</option>
                    @endforeach
                </select>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" step="any" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required>

                @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Total Price</label>
                <input type="number" step="any" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>

                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="godown">Godown</label>
                <select name="godown" id="godown" class="form-control @error('godown') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach ($godowns as $godown)
                        <option value="{{$godown->id}}" @if(old('godown')==$godown->id) selected @endif>{{$godown->name}}</option>
                    @endforeach
                </select>

                @error('godown')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="supplier">Supplier</label>
                <select name="supplier" id="supplier" class="form-control @error('supplier') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{$supplier->id}}" @if(old('supplier')==$supplier->id) selected @endif>{{$supplier->name}}</option>
                    @endforeach
                </select>

                @error('supplier')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group pb-1">
                <label for="date">Product Date</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>

                @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <hr>
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection
