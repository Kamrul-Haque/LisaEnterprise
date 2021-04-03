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
            width: 80%;
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
        <div class="pb-0">
            <div>
                <a class="btn btn-light float-left" href=" {{route('godowns.index')}} ">Back</a>
            </div>
            <div class="text-center">
                <h2>{{$godown->name}} - Stock</h2>
            </div>
        </div>
        <hr>
        <h4>Products</h4>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover pt-3" id="products">
                    <tr>
                        <th>#</th>
                        <th>NAME</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Transfer</th>
                    </tr>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td> {{$loop->iteration}} </td>
                            <td> {{$product->name}} </td>
                            <td> {{$product->pivot->quantity}} </td>
                            <td> {{$product->unit}} </td>
                            <td>
                                <a href="{{ route('product-transfers.create', ['godown'=>$godown,'product'=>$product]) }}" class="btn btn-primary btn-sm">
                                    <span data-feather="log-out" style="height: 15px; width: 15px; padding: 0"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <h4>Entries</h4>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover pt-3" id="entries">
                    <tr>
                        <th>#</th>
                        <th>SL NO.</th>
                        <th>NAME</th>
                        <th>QUANTITY</th>
                        <th>UNIT</th>
                        <th>ENTRY DATE</th>
                        <th>BOUGHT FROM</th>
                        <th>PRICE</th>
                    </tr>
                    <tbody>
                    @foreach ($entries as $entry)
                        <tr>
                            <td> {{$loop->iteration}} </td>
                            <td> {{$entry->sl_no}} </td>
                            <td> {{$entry->product->name}} </td>
                            <td> {{$entry->quantity}} </td>
                            <td> {{$entry->unit}} </td>
                            <td> {{$entry->date}} </td>
                            <td> {{$entry->supplier->name}} </td>
                            <td> {{$entry->buying_price}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <hr>
        <div class="form-group row">
            <div class="col-md-2">
                <a class="btn btn-primary float-left" href=" {{route('godowns.edit', $godown)}} ">Edit</a>
            </div>
            <div class="col-md-8">
                <ul class="pagination justify-content-center" id="prodLinks">
                    {{ $products->links() }}
                </ul>
                <ul class="pagination justify-content-center" id="entLinks">
                    {{ $entries->links() }}
                </ul>
            </div>
            <div class="col-md-2">
                @auth('admin')
                <button type="button" id="rightbutton" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteAllModal">Delete</button>
                @endauth
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="deleteAllModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title">Delete Confirmation</p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body text-danger font-weight-bold">
                    <h4>Do you really want to delete the Godown? All related records will be deleted!</h4>
                </div>

                <div class="modal-footer">
                    <form action="{{route('admin.godowns.destroy', $godown)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Confirm</button>
                    </form>
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection


