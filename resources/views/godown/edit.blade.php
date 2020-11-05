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
        <h2>Edit Godown - {{$godown->name}}</h2>
        <hr>
        <form class="form was-validated" action="{{route('godowns.update', $godown)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Godown Name</label>
                <input type="text" id="name" name="name" class="form-control" required value="{{$godown->name}}">
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" class="form-control" value="{{$godown->location}}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <div id="phone" class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">+880</div>
                    </div>
                    <input type="tel" class="form-control" name="phone" value="{{$godown->phone}}">
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection
