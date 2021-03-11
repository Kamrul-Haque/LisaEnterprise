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
        <h2 style="float: right">Payments</h2>
        <hr>
        @if($supplierPayments->count())
            <div class="card card-body bg-light">
                <div class="table-responsive-lg">
                    <table class="table table-striped table-hover pt-3" id="table">
                       <tr>
                           <th>#</th>
                           <th>SL No.</th>
                           <th>Client Name</th>
                           <th>Type</th>
                           <th>Amount</th>
                           <th>Payment Date</th>
                           <th>Account No.</th>
                           <th>Status</th>
                           <th>Date of Draw</th>
                           <th>Card No.</th>
                           <th>Validity</th>
                           <th>CVV</th>
                           <th>Received By</th>
                           <th>OPERATIONS</th>
                       </tr>
                        <tbody>
                        @foreach ($supplierPayments as $payment)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$payment->sl_no}} </td>
                                <td> {{$payment->supplier->name}} </td>
                                <td> {{$payment->type}} </td>
                                <td> {{$payment->amount}} </td>
                                <td> {{$payment->date_of_issue}} </td>
                                <td> {{$payment->acc_no}} </td>
                                <td> {{$payment->status}} </td>
                                <td> {{$payment->date_of_draw}} </td>
                                <td> {{$payment->card_no}} </td>
                                <td> {{$payment->validity}} </td>
                                <td> {{$payment->cvv}} </td>
                                <td> {{$payment->received_by}} </td>
                                <td>
                                    <div class="row justify-content-center">
                                        @if($payment->status == 'Pending')
                                        <a class="btn btn-outline-primary btn-sm d-inline-block" href="{{ route('supplier-payment.edit', $payment) }}">Change Status</a>
                                        @endif
                                        @auth('admin')
                                        <button class="btn btn-warning btn-sm" name="delete" title="delete" data-toggle="modal" data-target="#delete">
                                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                                        </button>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                            @component('layouts.components.delete-modal')
                                action="{{route('admin.supplier-payment.destroy', $payment)}}"
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
            <div class="col-md-3">
                <a class="btn btn-success float-left" href=" {{route('supplier-payment.create')}} ">Add New</a>
            </div>
            <div class="col-md-6">
                <ul class="pagination justify-content-center">
                    {{ $supplierPayments->links() }}
                </ul>
            </div>
            <div class="col-md-3">
                @auth('admin')
                <button type="button" id="rightbutton" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteAllModal">Delete All</button>
                @endauth
            </div>
        </div>
    </div>
    <!-- The Modal -->
    @if($supplierPayments->count())
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
                        <form action="#" method="post">
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
