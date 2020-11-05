@extends('layouts.app')
@section('style')
    <style>
        html, body, th {
            background-color: #fff;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            margin: 0;
        }
    </style>
    @if(Auth::guard('admin')->check())
        <style>
            .card-header{
                background-color: #23272b;
                color: white;
                font-size: large;
            }
        </style>
    @else
        <style>
            .card-header{
                background-color: #3490dc;
                color: white;
                font-size: large;
            }
        </style>
    @endif
@endsection
@section('content')
    <div class="container">
        <h4 class="display-4">Search Results</h4>

        <p>There are {{ $searchResults->count() }} result(s) for "{{$string}}"</p>

        @foreach($searchResults->groupByType() as $type => $modelSearchResults)
            <div class="card mt-2 mb-2">
                <div class="card-header">{{ $type }}</div>

                <div class="card-body">
                    @foreach($modelSearchResults as $searchResult)
                        <ul>
                            <li>
                                @if($searchResult->url)
                                    <a href="{{ $searchResult->url }}">{{ $searchResult->title }}</a>
                                @else
                                    <div>{{ $searchResult->title }}</div>
                                @endif
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>
        @endforeach
        @if(Auth::guard('admin')->check())
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">Back</a>
        @else
        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">Back</a>
        @endif
    </div>
@endsection
