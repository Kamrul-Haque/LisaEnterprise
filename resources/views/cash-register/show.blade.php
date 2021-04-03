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
        <a class="btn btn-light" href=" {{route('admin.dashboard')}} ">Back</a>
        <h2 style="float: right">Cash Register</h2>
        <hr>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover pt-3" id="table">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>OPERATIONS</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td> 1 </td>
                            <td> {{$cashRegister->type}} </td>
                            <td> {{number_format($cashRegister->amount, 2)}} </td>
                            <td> {{$cashRegister->title}} </td>
                            <td> {{$cashRegister->description}} </td>
                            <td>
                                @auth('admin')
                                    <button class="btn btn-warning btn-sm" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                                        <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                                    </button>
                                    @component('layouts.components.delete-modal')
                                        action="{{route('admin.cash-register.destroy', $cash)}}"
                                        @slot('loop') {{$loop->index}} @endslot
                                    @endcomponent
                                @endauth
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <a href="{{ route('admin.cash-register.withdraw') }}" class="btn btn-block btn-secondary">Withdraw</a>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('admin.cash-register.deposit') }}" class="btn btn-block btn-dark">Deposit</a>
            </div>
        </div>
    </div>
@endsection
