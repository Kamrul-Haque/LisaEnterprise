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
        <div class="form-group row pb-0">
            <div class="col-md-4">
                <a class="btn btn-light float-left" href=" {{route('supplier.index')}} ">Back</a>
            </div>
            <div class="col-md-4 justify-content-center" style="padding-left: 100px">
                <h2>Client History</h2>
            </div>
            <div class="col-sm-4">
                <button id="payment" type="button" class="btn btn-light float-right">Payments</button>
                <button id="invoice" type="button" class="btn btn-light float-right">Invoices</button>
            </div>
        </div>
        <hr>
        <h5>Name: {{ $supplier->name }}</h5>
        <h5>Phone: {{ $supplier->phone }}</h5>
        <h5>Address: {{ $supplier->address}}</h5>
        <h5>Email: {{ $supplier->email}}</h5>
        <br>
        {{--<div class="card card-body bg-light">
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
                            <td> {{number_format($invoice->subtotal, 2)}} </td>
                            <td> {{number_format($invoice->discount, 2)}} </td>
                            <td> {{number_format($invoice->grand_total, 2)}} </td>
                            <td> {{number_format($invoice->paid, 2)}} ({{$invoice->payment->status}}) </td>
                            <td> {{number_format($invoice->due, 2)}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table class="table table-striped table-hover" id="paymentTable">
                    <tr>
                        <th>#</th>
                        <th>Serial No.</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th class="text-center">OPERATION</th>
                    </tr>
                    <tbody>
                    @foreach ($paychecks as $paycheck)
                        <tr>
                            <td> {{$loop->iteration}} </td>
                            <td> {{$paycheck->sl_no}} </td>
                            <td> {{$paycheck->date_of_issue}} </td>
                            <td> {{number_format($paycheck->amount, 2)}} </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-dark btn-sm d-inline-block pr-2" title="products"><span data-feather="eye" style="width: 15px; height: 15px; padding: 0"></span></a>
                                <a href="{{route('payments.edit', $paycheck)}}" class="btn btn-primary btn-sm d-inline-block pr-2" title="products"><span data-feather="edit" style="width: 15px; height: 15px; padding: 0"></span></a>
                                @if(Auth::guard('admin')->check())
                                <form class="d-inline-block" action="{{route('payments.destroy', $paycheck)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-warning btn-sm" title="delete"><span data-feather="trash-2" style="width: 15px; height: 15px; padding: 0"></span></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>--}}
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
            {{ $paychecks->links() }}
        </ul>--}}
    </div>
    <script type="text/javascript">
        $(function () {
            $('#paymentTable').hide();
            $('#payLinks').hide();
            window.onafterprint = function () {
                window.location.replace("{{route('admin.dashboard')}}");
            }
        });
        $(document).on('click', '#payment', function () {
            $('#invoiceTable').hide();
            $('#invLinks').hide();
            $('#paymentTable').show();
            $('#payLinks').show();
        });
        $(document).on('click', '#invoice', function () {
            $('#paymentTable').hide();
            $('#payLinks').hide();
            $('#invoiceTable').show();
            $('#invLinks').show();
        });
    </script>
@endsection
