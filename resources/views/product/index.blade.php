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
        a.btn-primary{
            margin-left: 3px;
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
        <h2 style="float: right">Products</h2>
        <hr>
        @if($products->count())
            <div class="card card-body bg-light">
                <div class="table-responsive-lg">
                    <table class="table table-striped table-hover pt-3" id="table">
                        <tr>
                            <th>#</th>
                            <th>NAME</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            @if(Auth::guard('admin')->check())
                            <th>Unit Price</th>
                            <th>Price</th>
                            <th class="text-center">OPERATIONS</th>
                            @endif
                        </tr>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td> {{$product->name}} </td>
                                    <td> {{$product->totalQuantity()}} </td>
                                    <td> {{$product->unit}} </td>
                                    @if(Auth::guard('admin')->check())
                                    <td> {{number_format($product->unitPrice(),2)}} </td>
                                    <td> {{$product->totalPrice()}} </td>
                                    @endif
                                    @if(Auth::guard('admin')->check())
                                    <td>
                                        <div class="row justify-content-center">
                                            <a href="{{route('products.edit', $product)}} " class="btn btn-primary btn-sm" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                                            <button class="btn btn-warning btn-sm" name="delete" title="delete" data-toggle="modal" data-target="#delete"><span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span></button>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @component('layouts.components.delete-modal')
                                    action="{{route('products.destroy', $product)}}"
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
        <div class="form-group row">
            <div class="col-md-6">
                <a class="btn btn-success float-left" href=" {{route('products.create')}} ">Create New</a>
                <a class="btn btn-primary float-left" href=" {{route('invoices.create')}} ">Sell </a>
            </div>

            <div class="col-md-4">
                <ul class="pagination justify-content-center">
                    {{ $products->links() }}
                </ul>
            </div>
            <div class="col-md-2">
                @if(Auth::guard('admin')->check())
                <button type="button" id="rightbutton" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteAllModal">Delete All</button>
                @endif
            </div>
        </div>
    </div>
     <!-- The Modal -->
    @if($products->count())
    <div class="modal fade" id="deleteAllModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title">Delete Confirmation</p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body text-danger font-weight-bold">
                    <h4>Do you really want to delete all the records!</h4>
                </div>

                <div class="modal-footer">
                    <form action="{{route('admin.products.deleteAll')}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Confirm</button>
                    </form>
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
