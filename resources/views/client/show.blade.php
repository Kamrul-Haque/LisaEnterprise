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
        <div class="pb-0">
            <div>
                <a class="btn btn-light float-left" href=" {{route('clients.index')}} ">Back</a>
            </div>
            <div class="text-center" style="padding-left: 100px">
                <h2>Client History</h2>
            </div>
        </div>
        <hr>
        <h5>Name: {{ $client->name }}</h5>
        <h5>Phone: {{ $client->phone }}</h5>
        <h5>Address: {{ $client->address}}</h5>
        <h5>Email: {{ $client->email}}</h5>
        <br>
        <h4>Invoices</h4>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover" id="invoiceTable">
                    <tr>
                        <th>#</th>
                        <th>Serial No.</th>
                        <th>Date</th>
                        <th>Products</th>
                        <th>Labour Cost</th>
                        <th>Transport Cost</th>
                        <th>Subtotal</th>
                        <th>Discount</th>
                        <th>Grand Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                    </tr>
                    <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td> {{$loop->iteration}} </td>
                            <td> {{$invoice->sl_no}} </td>
                            <td> {{$invoice->date}} </td>
                            <td> <a href="{{route('invoices.show', $invoice)}}" title="products"><span data-feather="eye" style="width: 15px; height: 15px; padding: 0"></span></a> </td>
                            <td> {{$invoice->labour_cost}} </td>
                            <td> {{$invoice->transport_cost}} </td>
                            <td> {{$invoice->subtotal}} </td>
                            <td> {{$invoice->discount}} </td>
                            <td> {{$invoice->grand_total}} </td>
                            <td> {{$invoice->paid}} ({{$invoice->clientPayment->status}}) </td>
                            <td> {{$invoice->due}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <h4>Payments</h4>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover" id="paymentTable">
                    <tr>
                        <th>#</th>
                        <th>Serial No.</th>
                        <th>Date</th>
                        <th>Amount</th>
                    </tr>
                    <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td> {{$loop->iteration}} </td>
                            <td> {{$payment->sl_no}} </td>
                            <td> {{$payment->date_of_issue}} </td>
                            <td> {{number_format($payment->amount, 2)}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="col-sm row">
            <div>
                <h5>Total Purchase: {{$client->total_purchase}} </h5>
                <h5>Total Due: {{$client->total_due}} </h5>
            </div>
        </div>
        <ul id="invLinks" class="pagination justify-content-center">
            {{ $invoices->links() }}
        </ul>
        <ul id="payLinks" class="pagination justify-content-center">
            {{ $payments->links() }}
        </ul>
    </div>
@endsection
