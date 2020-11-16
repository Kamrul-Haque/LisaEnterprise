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
        <h2>Edit Godown</h2>
        <hr>
        <form action="{{route('godowns.update', $godown)}}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">Godown Name</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $godown->name }}" required>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ $godown->location }}" required>

                @error('location')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <div id="phone" class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">+880</div>
                    </div>
                    <input id="phone" type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $godown->phone }}">

                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection
