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
        @if($cashs->count())
            <div class="card card-body bg-light">
                <div class="table-responsive-lg">
                    <table class="table table-striped table-hover pt-3" id="table">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>OPERATIONS</th>
                        </tr>
                        <tbody>
                        @foreach ($cashs as $cash)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$cash->type}} </td>
                                <td> {{number_format($cash->amount, 2)}} </td>
                                <td> {{$cash->date}} </td>
                                <td> {{$cash->title}} </td>
                                <td> {{$cash->description}} </td>
                                <td>
                                    @auth('admin')
                                    <button class="btn btn-warning btn-sm" name="delete" title="delete" data-toggle="modal" data-target="#delete">
                                        <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                                    </button>
                                    @endauth
                                </td>
                            </tr>
                            @component('layouts.components.delete-modal')
                                action="{{route('admin.cash-register.destroy', $cash)}}"
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
                <a class="btn btn-success mr-1" href="{{ route('admin.cash-register.withdraw') }}">Withdraw</a>
                <a class="btn btn-success mr-1" href="{{ route('admin.cash-register.deposit') }}">Deposit</a>
                <a class="btn btn-outline-success mr-1" href="{{ route('cash-register.withdraw.bank') }}">Withdraw To Bank</a>
                <a class="btn btn-outline-success" href="{{ route('cash-register.deposit.bank') }}">Deposit From Bank</a>
            </div>
            <div class="col-md-4">
                <ul class="pagination justify-content-center">
                    {{ $cashs->links() }}
                </ul>
            </div>
            <div class="col-md-2">
                @auth('admin')
                <button type="button" id="rightbutton" class="btn btn-danger float-right ml-1" data-toggle="modal" data-target="#deleteAllModal">Delete All</button>
                @endauth
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="deleteAllModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title">Delete Confirmation</p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body text-danger font-weight-bold">
                    <h4>Do you really want to delete all records?</h4>
                </div>

                <div class="modal-footer">
                    <form action="{{route('admin.cash-register.deleteAll')}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Confirm</button>
                    </form>
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
