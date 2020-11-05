@extends('layouts.app')
@section('style')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            margin: 0;
        }
        .container{
            width: 500px;
        }
        label{
            font-size: medium;
        }
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
@section('content')
    <div class="container m-auto">
        <h2>Change Status</h2>
        <hr>
        <form id="form" class="form was-validated" action="{{route('payments.update', $payment)}}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="" selected disabled>Please Select...</option>
                    <option value="Drawn">Drawn</option>
                    <option value="Failed">Failed</option>
                </select>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
    <script type="text/javascript">
        $(document).on('change','#status',function () {
            var status = $(this).val();
            $('.added').remove();

            if(status === 'Drawn')
            {
                var html = `<div class="form-group pt-3 added">
                                <label for="date">Date of Draw</label>
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>`;

                $(html).insertAfter(this);
            }
        });
    </script>
@endsection
