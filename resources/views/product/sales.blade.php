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
                <div id="collapse{{$loop->index}}" class="collapse" aria-labelledby="heading{{$loop->index}}" data-parent="#accordionExample">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Client Name</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($product->invoiceProducts as $sold)
                                <tr>
                                    <td>{{ $sold->invoice->client->name }}</td>
                                    <td>{{ $sold->quantity }} {{ $sold->unit }}</td>
                                    <td>{{ $sold->invoice->date }}</td>
                                    <td>{{ $sold->unit_selling_price }}</td>
                                    <td>{{ $sold->total_selling_price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
