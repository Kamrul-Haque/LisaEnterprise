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
    <div class="container-fluid pl-5 pr-5">
        <a class="btn btn-light" href=" {{route('admin.dashboard')}} ">Back</a>
        <h2 style="float: right">Product Transfers</h2>
        <hr>
        @if($productTransfers->count())
            <div class="card card-body bg-light">
                <div class="table-responsive-lg">
                    <table class="table table-striped table-hover pt-3" id="table">
                        <tr>
                            <th>#</th>
                            <th>Sl No.</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Godown From</th>
                            <th>Godown To</th>
                            <th>Date</th>
                            <th>Entry by</th>
                            @auth('admin')
                            <th class="text-center">OPERATIONS</th>
                            @endauth
                        </tr>
                        <tbody>
                        @foreach ($productTransfers as $transfer)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$transfer->sl_no}} </td>
                                <td> {{$transfer->product->name}} </td>
                                <td> {{$transfer->quantity}} </td>
                                <td> {{$transfer->godownFrom->name}} </td>
                                <td> {{$transfer->godownTo->name}} </td>
                                <td> {{$transfer->date}} </td>
                                <td> {{$transfer->entry_by}} </td>
                                @auth('admin')
                                <td>
                                    <div class="row justify-content-center">
                                        <button class="btn btn-warning btn-sm" name="delete" title="delete" data-toggle="modal" data-target="#delete">
                                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                                        </button>
                                    </div>
                                </td>
                                @endauth
                            </tr>
                            @component('layouts.components.delete-modal')
                                action="{{route('admin.product-transfers.destroy', $transfer)}}"
                            @endcomponent
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="card card-body bg-light text-center">
                <p class="display-4">No Records Found!</p>
            </div>
        @endif
        <hr>
        <div class="col-md-8">
            <ul class="pagination justify-content-center">
                {{ $productTransfers->links() }}
            </ul>
        </div>
    </div>
@endsection
