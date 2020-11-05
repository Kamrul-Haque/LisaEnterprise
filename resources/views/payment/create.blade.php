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
        <h2>Add Payment</h2>
        <hr>
        <form id="form" class="form was-validated" action="{{route('payments.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="client">Client Name</label>
                <select id="client" name="client" class="form-control" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach ($clients as $client)
                        <option value="{{$client->id}}">{{$client->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="" selected disabled>Please Select...</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Card">Card</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="any" id="amount" name="amount" class="form-control" required>
            </div>
            <div class="form-group pb-1">
                <label for="date">Payment Date/Date of Issue</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <hr>
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
    <script type="text/javascript">
        $(document).on('change','#type',function () {
             var type = $(this).val();

             $('.added').remove();
             if (type === 'Cheque')
             {
                 var html = `<div class="form-group pt-3 added">
                                 <label for="account">Account No.</label>
                                 <input type="number" id="account" name="account" class="form-control" required>
                             </div>`;

                 $(html).insertAfter(this);
             }
             if(type === 'Card')
             {
                 var html = `<div class="form-group pt-3 added">
                                 <label for="card">Card No.</label>
                                 <input type="number" id="card" name="card" class="form-control" required>
                             </div>
                            <div class="form-group row added">
                                <div class="col-md-6">
                                    <label for="validity">Validity</label>
                                    <input type="text" id="validity" name="validity" class="form-control" placeholder="07/20" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cvv">CVV</label>
                                    <input type="number" id="cvv" name="cvv" class="form-control">
                                </div>
                            </div>`;

                 $(html).insertAfter(this);
             }
        });
    </script>
@endsection

