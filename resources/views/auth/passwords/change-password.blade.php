@extends('layouts.app')
@section('style')
    <style>
        .btn{
            color: white;
        }
        .btn:hover{
            color: white;
        }
    </style>
    @if(Auth::guard('admin')->check())
        <style>
            .card-header{
                background-color: #23272b;
                color: white;
            }
        </style>
    @else
        <style>
            .card-header{
                background-color: #3490dc;
                color: white;
            }
        </style>
    @endif
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Change Password</div>

                    <div class="card-body">
                        @if(Auth::guard('admin')->check())
                        <form method="POST" class="was-validated" action="{{route('admin.accounts.password.change.store')}}">
                        @else
                        <form method="POST" class="was-validated" action="{{route('users.password.change.store')}}">
                        @endif
                            @csrf
                            <input type="hidden" name="id" value="{{Auth::user()->id}}">

                            <div class="form-group row">
                                <label for="old" class="col-md-4 col-form-label text-md-right">Old Password</label>

                                <div class="col-md-6">
                                    <input id="old" name="old" type="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                                <div class="col-md-6">
                                    <input id="password" name="password" type="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    @if(Auth::guard('admin')->check())
                                    <button type="submit" class="btn btn-dark">Submit</button>
                                    @else
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
