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
@endsection
@section('content')
    <div class="container">
        <a class="btn btn-light" href=" {{route('admin.dashboard')}} ">Back</a>
        <h2 style="float: right">Godowns</h2>
        <hr>
        @if($godowns->count())
            <div class="card card-body bg-light">
                @component('layouts.components.godown-table', ['godowns'=>$godowns])
                    godowns
                @endcomponent
            </div>
        @else
        <div class="card card-body bg-light text-center">
            <p class="display-4">No Records Found!</p>
        </div>
        @endif
        <hr>
        <div class="form-group row">
            <div class="col-md-4">
                <a class="btn btn-success float-left" href=" {{route('godowns.create')}} ">Create New</a>
            </div>
            <div class="col-md-4">
                <ul class="pagination justify-content-center">
                    {{ $godowns->links() }}
                </ul>
            </div>
            <div class="col-md-4">
                @auth('admin')
                    <button type="button" id="rightbutton" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteAllModal">Delete All</button>
                @endauth
            </div>
        </div>
    </div>
     <!-- The Modal -->
    @if($godowns->count())
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
                    <form action="{{route('admin.godowns.deleteAll')}}" method="post">
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
