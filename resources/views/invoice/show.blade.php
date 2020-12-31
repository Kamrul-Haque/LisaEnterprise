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
        <h2>Invoice Details</h2>
        <hr>
        <h5>Serial Number: {{ $invoice->sl_no }}</h5>
        <h5>Date: {{ $invoice->date }}</h5>
        <h5>Client Name: {{ $invoice->client->name }}</h5>
        <br>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover" id="table">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Godown</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td> {{$loop->iteration}} </td>
                            <td> {{$product->product->name}} </td>
                            <td> {{$product->godown->name}} </td>
                            <td> {{$product->quantity}} </td>
                            <td> {{$product->unit}} </td>
                            <td> {{$product->unit_selling_price}} </td>
                            <td> {{$product->total_selling_price}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-9">
                <h5>Labour Cost: {{$invoice->labour_cost}} </h5>
                <h5>Transport Cost: {{$invoice->transport_cost}} </h5>
                <h5>Subtotal: {{$invoice->subtotal}} </h5>
                <h5>Discount: {{$invoice->discount}} </h5>
            </div>
            <div class="col-md-3 float-right" style="text-align: right">
                <h5>Grand Total: {{$invoice->grand_total}} </h5>
                <h5>Paid: {{$invoice->paid}} </h5>
                <h5>Due: {{$invoice->due}} </h5>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-md-2">
                <a class="btn btn-light" href=" {{url()->previous()}} ">Back</a>
            </div>
            <div class="col-md-8">
                <ul class="pagination justify-content-center">
                    {{ $products->links() }}
                </ul>
            </div>
            <div class="col-md-2">
                <a class="btn btn-success float-right" href="{{route('invoices.print',$invoice)}}"><span data-feather="printer" style="width: 15px; height: 15px; padding: 0; margin-right: 3px"></span>Print</a>
            </div>
        </div>
    </div>
@endsection


