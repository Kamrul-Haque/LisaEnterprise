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
        <h2>Entry Product</h2>
        <hr>
        <form action="{{route('entries.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <select id="name" name="name" class="form-control @error('name') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach ($products as $product)
                        <option value="{{$product->id}}" @if(old('name')==$product->id) selected @endif>{{$product->name}}</option>
                    @endforeach
                </select>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" step="any" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required>

                @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Total Price</label>
                <input type="number" step="any" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>

                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="godown">Godown</label>
                <select name="godown" id="godown" class="form-control @error('godown') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach ($godowns as $godown)
                        <option value="{{$godown->id}}" @if(old('godown')==$godown->id) selected @endif>{{$godown->name}}</option>
                    @endforeach
                </select>

                @error('godown')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="supplier">Supplier</label>
                <select name="supplier" id="supplier" class="form-control @error('supplier') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{$supplier->id}}" @if(old('supplier')==$supplier->id) selected @endif>{{$supplier->name}}</option>
                    @endforeach
                </select>

                @error('supplier')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group pb-1">
                <label for="date">Entry Date</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>

                @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Payment Type</label>
                <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    <option value="Cash" @if(old('type')=="Cash") selected @endif>Cash</option>
                    <option value="Cheque" @if(old('type')=="Cheque") selected @endif>Cheque</option>
                    <option value="Card" @if(old('type')=="Card") selected @endif>Card</option>
                </select>

                @error('type')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group cheque-group">
                <label for="cheque_no">Cheque No.</label>
                <input type="number" id="cheque_no" name="cheque_no" class="form-control @error('cheque_no') is-invalid @enderror" value="{{ old('cheque_no') }}">

                @error('cheque_no')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group card-group">
                <label for="card">Card No.</label>
                <input type="number" id="card" name="card" class="form-control @error('card') is-invalid @enderror" value="{{ old('card') }}">

                @error('card')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group row card-group">
                <div class="col-md-6">
                    <label for="validity">Validity</label>
                    <input type="text" id="validity" name="validity" class="form-control @error('validity') is-invalid @enderror" placeholder="07/20" value="{{ old('validity') }}">

                    @error('validity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="cvv">CVV</label>
                    <input type="number" id="cvv" name="cvv" class="form-control @error('cvv') is-invalid @enderror" value="{{ old('cvv') }}">

                    @error('cvv')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="any" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>

                @error('amount')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-8">Due</label>
                <label id="dueLabel" class="col-form-label col-md-4 text-right"></label>
                <input type="text" id="due" name="due" hidden>
            </div>
            <hr>
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('entries.index') }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function (){
            var type = $('#type').val();

            if (type == 'Cheque')
            {
                $('.cheque-group').show();
                $('.card-group').hide();
                $('#card').val(null);
                $('#validity').val(null);
                $('#cvv').val(null);
            }
            else if(type == 'Card') {
                $('.card-group').show();
                $('.cheque-group').hide();
                $('#cheque_no').val(null);
            }
            else
            {
                $('.card-group').hide();
                $('#card').val(null);
                $('#validity').val(null);
                $('#cvv').val(null);
                $('.cheque-group').hide();
                $('#cheque_no').val(null);
            }
        });
        $(document).on('change','#type',function () {
            var type = $(this).val();

            if (type === 'Cheque')
            {
                $('.cheque-group').show();
                $('.card-group').hide();
                $('#card').val(null);
                $('#validity').val(null);
                $('#cvv').val(null);
            }
            else if(type === 'Card') {
                $('.card-group').show();
                $('.cheque-group').hide();
                $('#cheque_no').val(null);
            }
            else
            {
                $('.card-group').hide();
                $('#card').val(null);
                $('#validity').val(null);
                $('#cvv').val(null);
                $('.cheque-group').hide();
                $('#cheque_no').val(null);
            }
        });
        $(document).on('input','#price', function (){
            var due = parseFloat($('#price').val()) - parseFloat($('#amount').val());

            $('#due').val(parseFloat(due));
            $('#dueLabel').html(parseFloat(due));
        });
        $(document).on('input','#amount', function (){
            var due = parseFloat($('#price').val()) - parseFloat($('#amount').val());

            $('#due').val(parseFloat(due));
            $('#dueLabel').html(parseFloat(due));
        });
    </script>
@endsection
