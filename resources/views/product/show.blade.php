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
        .container{
            width: 65%;
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
        <a class="btn btn-light" href=" {{ route('products.index')}} ">Back</a>
        <h2 style="float: right">Products</h2>
        <hr>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover pt-3" id="table">
                    <tr>
                        <th>#</th>
                        <th>NAME</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        @auth('admin')
                            <th class="text-center">OPERATIONS</th>
                        @endauth
                    </tr>
                    <tbody>
                        <tr>
                            <td> 1 </td>
                            <td> {{$product->name}} </td>
                            <td> {{$product->total_quantity}} </td>
                            <td> {{$product->unit}} </td>
                            @if(Auth::guard('admin')->check())
                                <td> {{$product->unit_buying_price}} </td>
                                <td> {{$product->total_price}} </td>
                            @endif
                            <td>
                                <div class="row justify-content-center">
                                    <a href="{{route('products.edit', $product)}} " class="btn btn-primary btn-sm" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                                    @auth('admin')
                                        <button class="btn btn-warning btn-sm" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                                        </button>
                                        @component('layouts.components.delete-modal')
                                            action="{{route('admin.products.destroy', $product)}}"
                                            @slot('loop') {{$loop->index}} @endslot
                                        @endcomponent
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <a href="{{route('payments.create')}}" class="btn btn-block btn-success d-block">Add New</a>
    </div>
@endsection
