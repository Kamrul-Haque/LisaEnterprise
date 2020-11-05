@extends('layouts.app')
@section('style')
    <style>
        html, body, th {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            margin: 0;
        }
    </style>
    @if(Auth::guard('admin')->check())
        <style>
            th{
                background-color: #23272b;
                color: whitesmoke;
            }
        </style>
    @else
        <style>
            th{
                background-color: #3490dc;
                color: whitesmoke;
            }
        </style>
    @endif
@endsection
@section('content')
    <div class="container">
        <a class="btn btn-light" href=" {{route('admin.dashboard')}} ">Back</a>
        <h2 style="float: right">Product Entries</h2>
        <hr>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover pt-3" id="table">
                    <tr>
                        <th>#</th>
                        <th>SL NO.</th>
                        <th>NAME</th>
                        <th>QUANTITY</th>
                        <th>UNIT</th>
                        <th>GODOWN</th>
                        <th>ENTRY DATE</th>
                        <th>BOUGHT FROM</th>
                        <th>ENTRY BY</th>
                        <th>PRICE</th>
                        <th><center>OPERATIONS</center></th>
                    </tr>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td> {{$entry->sl_no}} </td>
                            <td> {{$entry->product->name}} </td>
                            <td> {{$entry->quantity}} </td>
                            <td> {{$entry->unit}} </td>
                            <td> {{$entry->godown->name}} </td>
                            <td> {{$entry->entry_date}} </td>
                            <td> {{$entry->bought_from}} </td>
                            <td> {{$entry->entry_by}} </td>
                            <td> {{$entry->buying_price}} </td>
                            <td>
                                <div class="row justify-content-center">
                                    <form class="pl-1" action="{{route('admin.entries.destroy', $entry->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-warning btn-sm" name="delete" title="delete"><span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <a href="{{ route('admin.entries.create') }}" class="btn btn-success btn-block">Add New</a>
    </div>
@endsection
