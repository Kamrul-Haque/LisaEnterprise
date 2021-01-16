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
        th{
            background-color: #23272b;
            color: whitesmoke;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid pl-5 pr-5 main-wrapper">
        <a class="btn btn-light" href=" {{route('admin.dashboard')}} ">Back</a>
        <h2 style="float: right">Admin Accounts</h2>
        <hr>
        @if($admins->count())
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover pt-3" id="table">
                        <tr>
                            <th>#</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>JOB TITLE</th>
                            <th>NID NUMBER</th>
                            <th>PHONE</th>
                            <th>DATE OF BIRTH</th>
                            <th>ADDRESS</th>
                            <th class="text-center">OPERATIONS</th>
                        </tr>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$admin->name}} </td>
                                <td> {{$admin->email}} </td>
                                <td> {{$admin->job_title}} </td>
                                <td> {{$admin->nid}} </td>
                                <td> {{$admin->phone}} </td>
                                <td> {{$admin->date_of_birth}} </td>
                                <td> {{$admin->address}} </td>
                                <td>
                                    <div class="row justify-content-center">
                                        <a href="{{route('admin.accounts.edit',$admin->id)}}" class="btn btn-primary btn-sm" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                                        <button class="btn btn-warning btn-sm" name="delete" title="delete" data-toggle="modal" data-target="#delete"><span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span></button>
                                    </div>
                                </td>
                            </tr>
                            @component('layouts.components.delete-modal')
                                action="{{route('admin.accounts.destroy', $admin)}}"
                            @endcomponent
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="card card-body bg-light  justify-content-center">
            <center><p class="display-4">No Records Found!</p></center>
        </div>
        @endif
        <hr>
        <div class="form-group row">
            <div class="col-md-2">
                <a class="btn btn-success float-left" href=" {{route('admin.accounts.create')}} ">Add Admin</a>
            </div>
            <div class="col-md-8">
                <ul class="pagination justify-content-center">
                    {{ $admins->links() }}
                </ul>
            </div>
            <div class="col-md-2">
                <button type="button" id="rightbutton" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteAllModal">Delete All</button>
            </div>
        </div>
    </div>
     <!-- The Modal -->
    @if($admins->count())
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
                    <form action="{{route('admin.accounts.deleteAll')}} " method="post">
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
