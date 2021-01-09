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
    </style>
@endsection

@section('content')
    <div class="container m-auto">
        <h2>Change Status</h2>
        <hr>
        <form action="{{ route('client-payment.update', $clientPayment) }}" method="post">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    <option value="Drawn" @if(old('status') == "Drawn") selected @endif>Drawn</option>
                    <option value="Failed" @if(old('status') == "Failed") selected @endif>Failed</option>
                </select>

                @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div id="date-group" class="form-group">
                <label for="date">Date of Draw</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">

                @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('client-payment.index') }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function (){
            var status = $('#status').val();

            if(status == 'Drawn')
            {
                $('#date-group').show();
            }
            else
            {
                $('#date').val(null);
                $('#date-group').hide();
            }
        });

        $(document).on('change','#status',function () {
            var status = $(this).val();

            if(status == 'Drawn')
            {
                $('#date-group').show();
            }
            else
            {
                $('#date').val(null);
                $('#date-group').hide();
            }
        });
    </script>
@endsection
