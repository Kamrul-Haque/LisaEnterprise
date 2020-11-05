@extends('layouts.app')
@section('style')
<style>
    .card{
        font-size: medium;
    }
    a.btn{
        color: white;
    }
    a.btn:hover{
        color: white;
    }
</style>
@if(Auth::guard('admin')->check())
<style>
    .card-header{
        background-color: #23272b;
        color: white
    }
</style>
@else
<style>
    .card-header{
        background-color: #3490dc;
        color: white
    }
</style>
@endif
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Account Details</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input id="name" class="form-control" value="{{Auth::user()->name}}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input id="email" class="form-control" value="{{Auth::user()->email}}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="job" class="col-md-4 col-form-label text-md-right">Job Title</label>
                            <div class="col-md-6">
                                <input id="job" class="form-control" value="{{Auth::user()->job_title}}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nid" class="col-md-4 col-form-label text-md-right">NID</label>
                            <div class="col-md-6">
                                <input id="nid" class="form-control" value="{{Auth::user()->nid}}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>
                            <div class="col-md-6">
                                <input id="phone" class="form-control" value="{{Auth::user()->phone}}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                            <div class="col-md-6">
                                <textarea id="address" class="form-control" disabled>{{Auth::user()->address}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if(Auth::guard('admin')->check())
                                    <a class="btn btn-dark" href="{{route('admin.accounts.password.change')}}">
                                        Change Password
                                    </a>
                                @else
                                    <a class="btn btn-primary" href="{{route('users.password.change')}}">
                                        Change Password
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
