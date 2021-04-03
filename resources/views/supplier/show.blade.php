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
    @auth('admin')
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
    @endauth
@endsection
@section('content')
    <div class="container-fluid pl-5 pr-5">
        <div class="pb-0">
            <div>
                <a class="btn btn-light float-left" href=" {{route('suppliers.index')}} ">Back</a>
            </div>
            <div class="text-center" style="padding-left: 100px">
                <h2>Supplier History</h2>
            </div>
        </div>
        <hr>
        <h5>Name: {{ $supplier->name }}</h5>
        <h5>Phone: {{ $supplier->phone }}</h5>
        <h5>Address: {{ $supplier->address}}</h5>
        <h5>Email: {{ $supplier->email}}</h5>
        <br>
        <h4>Entries</h4>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover" id="invoiceTable">
                    <tr>
                        <th>#</th>
                        <th>Sl No.</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Godown</th>
                        <th>Date</th>
                        <th>Bought From</th>
                        <th>Entry by</th>
                        <th>Total Price</th>
                    </tr>
                    <tbody>
                    @foreach ($supplier->entries as $entry)
                        <tr>
                            <td> {{$loop->iteration}} </td>
                            <td> {{$entry->sl_no}} </td>
                            <td> {{$entry->product->name}} </td>
                            <td> {{$entry->quantity}} </td>
                            <td> {{$entry->unit}} </td>
                            <td> {{$entry->godown->name}} </td>
                            <td> {{$entry->date}} </td>
                            <td> {{$entry->supplier->name}} </td>
                            <td> {{$entry->entry_by}} </td>
                            <td> {{$entry->buying_price}} </td>
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
                    @foreach ($supplier->supplierPayments as $payment)
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
                <h5>Total Purchase: {{$supplier->total_purchase}} </h5>
                <h5>Total Due: {{$supplier->total_due}} </h5>
            </div>
        </div>
        {{--<ul id="invLinks" class="pagination justify-content-center">
            {{ $invoices->links() }}
        </ul>
        <ul id="payLinks" class="pagination justify-content-center">
            {{ $payments->links() }}
        </ul>--}}
    </div>
@endsection
