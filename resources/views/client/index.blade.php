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
        <h2 style="float: right">Clients</h2>
        <hr>
        @if($clients->count())
            <div class="card card-body bg-light ">
                <div class="table-responsive-lg">
                    <table class="table table-striped table-hover pt-3" id="table">
                        <tr>
                            <th>#</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>ADDRESS</th>
                            <th>Total Due</th>
                            <th>Total Purchase</th>
                            <th class="text-center">OPERATIONS</th>
                        </tr>
                        <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td> {{$client->name}} </td>
                                <td> {{$client->email}} </td>
                                <td> {{$client->phone}} </td>
                                <td> {{$client->address}} </td>
                                <td> {{$client->total_due}} </td>
                                <td> {{$client->total_purchase}} </td>
                                <td>
                                    <div class="row justify-content-center">
                                        <a href="{{route('clients.show',$client)}}" class="btn btn-dark btn-sm" title="client history"><span data-feather="eye" style="height: 15px; width: 15px; padding: 0"></span></a>
                                        <div class="pl-1">
                                            <a href="{{route('clients.edit',$client)}}" class="btn btn-primary btn-sm" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                                        </div>
                                        @auth('admin')
                                        <button class="btn btn-warning btn-sm" name="delete" title="delete" data-toggle="modal" data-target="#delete"><span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span></button>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                            @component('layouts.components.delete-modal')
                                action="{{route('admin.clients.destroy', $client)}}"
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
            <div class="col-md-2">
                <a class="btn btn-success float-left" href=" {{route('clients.create')}} ">Add Client</a>
            </div>
            <div class="col-md-8">
                <ul class="pagination justify-content-center">
                    {{ $clients->links() }}
                </ul>
            </div>
            <div class="col-md-2">
                @auth('admin')
                <button type="button" id="rightbutton" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteAllModal">Delete All</button>
                @endif
            </div>
        </div>
    </div>
    <!-- The Modal -->
    @if($clients->count())
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
                        <form action="{{route('admin.clients.deleteAll')}}" method="post">
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
