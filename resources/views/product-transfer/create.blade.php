@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h4>Product Transfer</h4>
        <hr>
        <form action="{{ route('product-transfers.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="product">Product</label>
                <input type="text" value="{{ $product->name }}" class="form-control" readonly>
                <input type="text" id="product" name="product" value="{{ $product->id }}" class="form-control" hidden>
            </div>
            <div class="form-group">
                <label for="from">Transfer From</label>
                <input type="text" value="{{ $godown->name }}" class="form-control" readonly>
                <input type="text" id="from" name="from" value="{{ $godown->id }}" class="form-control" hidden>
            </div>
            <div class="form-group">
                <label for="avlQuantity">Available Quantity</label>
                <input type="text" name="avlQuantity" id="avlQuantity" class="form-control" value="{{ $avlQuantity }}" readonly>
            </div>
            <div class="form-group">
                <label for="transferQuantity">Quantity to Transfer</label>
                <input type="text" name="transferQuantity" id="transferQuantity" class="form-control @error('transferQuantity') is-invalid @enderror" value="{{ old('transferQuantity') }}" required>

                @error('transferQuantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="to">Transfer To</label>
                <select type="text" id="to" name="to" class="form-control @error('to') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach($godowns as $godownt)
                        @if($godownt->id != $godown->id)
                            <option value="{{ $godownt->id }}" @if( old('to') == $godownt->id) selected @endif>{{ $godownt->name }}</option>
                        @endif
                    @endforeach
                </select>

                @error('to')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>

                @error('date')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <hr>
            <div class="form-group">
                <button type="submit" class="btn btn-success mr-1">Transfer</button>
                <a href="{{ route('godowns.show', $godown) }}" class="btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
@endsection
