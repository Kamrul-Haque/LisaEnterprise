@extends('layouts.app')

@section('style')
    <style>
        .dropdown-button{
            border: 0;
            background: transparent;
            color: black;
        }
        .dropdown-button:focus{
            outline: none;
            border: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid pl-5 pt-5">
        <h2>Products Sold</h2>
        <hr>
        <div class="accordion" id="accordionExample">
            @foreach($products as $product)
                <div class="card">
                    <div class="card-header" id="heading{{$loop->index}}">
                        <h4 class="mb-0">
                            <button class="dropdown-button btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapseOne">
                                {{ $product->name }}
                            </button>
                        </h4>
                    </div>
                    <div id="collapse{{$loop->index}}" class="collapse @if($product->invoiceProducts->count()) show @endif" aria-labelledby="heading{{$loop->index}}" data-parent="#accordionExample">
                        <div class="card-body">
                            @if($product->invoiceProducts->count())
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product->invoiceProducts as $invoiceProduct)
                                        <tr>
                                            <td>{{ $invoiceProduct->invoice->client->name }}</td>
                                            <td>{{ $invoiceProduct->quantity }} {{ $invoiceProduct->unit }}</td>
                                            <td>{{ $invoiceProduct->invoice->date }}</td>
                                            <td>{{ $invoiceProduct->unit_selling_price }}</td>
                                            <td>{{ $invoiceProduct->selling_price }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h4 class="text-center"><strong>No Records Found</strong></h4>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
