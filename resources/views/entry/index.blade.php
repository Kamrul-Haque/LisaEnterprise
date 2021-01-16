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
        <h2 style="float: right">Product Entries</h2>
        <hr>
        @if($entries->count())
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover pt-3" id="table">
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
                        <th><center>OPERATIONS</center></th>
                    </tr>
                    <tbody>
                        @foreach ($entries as $entry)
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
                                <td>
                                    <div class="row justify-content-center">
                                        <button class="btn btn-warning btn-sm" name="delete" title="delete" data-toggle="modal" data-target="#delete"><span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span></button>
                                    </div>
                                </td>
                            </tr>
                            @component('layouts.components.delete-modal')
                                action="{{route('admin.entries.destroy', $entry)}}"
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
                <a class="btn btn-success float-left" href=" {{route('admin.entries.create')}} ">Entry New</a>
            </div>
            <div class="col-md-8">
                <ul class="pagination justify-content-center">
                    {{ $entries->links() }}
                </ul>
            </div>
            <div class="col-md-2">
                <button type="button" id="rightbutton" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteAllModal">Delete All</button>
            </div>
        </div>
    </div>
     <!-- The Modal -->
    @if($entries->count())
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
                    <form action="{{route('admin.entries.deleteAll')}}" method="post">
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
