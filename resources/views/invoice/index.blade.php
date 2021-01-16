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
    <div class="container-fluid pr-5 pl-5">
        <a class="btn btn-light" href=" {{route('admin.dashboard')}} ">Back</a>
        <h2 style="float: right">Invoices</h2>
        <hr>
        @if($invoices->count())
            <div class="card card-body bg-light">
                <div class="table-responsive-lg">
                    <table class="table table-striped table-hover pt-3" id="table">
                        <tr>
                            <th>#</th>
                            <th>SL NO.</th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Labour Cost</th>
                            <th>Transport Cost</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>Grand Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Sold By</th>
                            <th class="text-center">OPERATIONS</th>
                        </tr>
                        <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$invoice->sl_no}} </td>
                                <td> {{$invoice->date}} </td>
                                <td> {{$invoice->client->name}} </td>
                                <td> {{$invoice->labour_cost}} </td>
                                <td> {{$invoice->transport_cost}} </td>
                                <td> {{$invoice->subtotal}} </td>
                                <td> {{$invoice->discount}}</td>
                                <td> {{$invoice->grand_total}} </td>
                                @if($invoice->clientPayment->status != 'N/A')
                                <td> {{$invoice->paid}}({{$invoice->clientPayment->status}}) </td>
                                @else
                                <td>{{$invoice->paid}}</td>
                                @endif
                                <td> {{$invoice->due}} </td>
                                <td> {{$invoice->sold_by}} </td>
                                <td>
                                    <div class="row justify-content-center">
                                        <a href="{{route('invoices.show',$invoice)}}" class="btn d-block btn-dark btn-sm" title="details"><span data-feather="eye" style="height: 15px; width: 15px; padding: 0"></span></a>
                                        <button class="btn btn-warning btn-sm" name="delete" title="delete" data-toggle="modal" data-target="#delete"><span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span></button>
                                    </div>
                                </td>
                            </tr>
                            @component('layouts.components.delete-modal')
                                action="{{route('invoices.destroy', $invoice)}}"
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
                <a class="btn btn-success float-left" href="{{route('invoices.create')}}">Add Invoice</a>
                <a class="btn btn-primary float-left" href=" {{route('quotation.print')}} ">Quotation</a>
            </div>
            <div class="col-md-3">
                <ul class="pagination justify-content-center">
                    {{ $invoices->links() }}
                </ul>
            </div>
            <div class="col-md-3">
                @if(Auth::guard('admin')->check())
                <button type="button" id="rightbutton" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteAllModal">Delete All</button>
                @endif
            </div>
        </div>
    </div>
    <!-- The Modal -->
    @if($invoices->count())
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
                        <form action="{{route('admin.invoices.deleteAll')}}" method="post">
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
