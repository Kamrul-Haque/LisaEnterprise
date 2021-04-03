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
                        <th class="text-center">OPERATIONS</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td> {{$payment->sl_no}} </td>
                            <td> {{$payment->client->name}} </td>
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
                                        <a class="btn btn-outline-primary btn-sm d-inline-block" href="{{route('client-payment.edit', $payment)}}">Change Status</a>
                                    @endif
                                    @auth('admin')
                                        <button class="btn btn-warning btn-sm" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                                        </button>
                                        @component('layouts.components.delete-modal')
                                            action="{{route('admin.client-payment.destroy', $payment)}}"
                                            @slot('loop') {{$loop->index}} @endslot
                                        @endcomponent
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <a href="{{route('client-payment.create')}}" class="btn btn-block btn-success d-block">Add New</a>
    </div>
@endsection
