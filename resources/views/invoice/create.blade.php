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
        .modal-lg {
            max-width: 1500px !important;
            padding-left: 20px;
        }
        .modal-md{
            max-width: 45% !important;
            padding-left: 200px;
        }
    </style>
    <script>var products = {!! $products !!}</script>
    <script>var inc = "{{asset('/icons/trash-2.svg')}}"</script>
@endsection

@section('content')
    <div class="container m-auto">
        <h3>Sell Product</h3>
        <hr>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong class="text-danger">{{ $error }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endforeach
        @endif
        <form action="{{route('invoices.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="date">Selling Date</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>

                @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Client Name</label>
                <select id="name" name="client" class="form-control @error('name') is-invalid @enderror" required>
                    <option value="" selected disabled>Please Select...</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @if(old('name')==$client->id) selected @endif>{{ $client->name }}</option>
                    @endforeach
                </select>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="products">Products</label>
                <button type="button" id="products" class="btn btn-block btn-outline-primary" data-toggle="modal" data-target="#productsModal">Select Products</button>
            </div>
            <div class="modal fade" id="productsModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-primary">Product Selection</h3>
                        </div>

                        <div id="body" class="modal-body font-weight-bold">
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="form-check-label">Product Name</label>
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-check-label">Gododwn</label>
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-check-label">Quantity</label>
                                </div>
                                <div class="col-sm-1">
                                    <label class="form-check-label">Unit</label>
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-check-label">Unit Price</label>
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-check-label">Total Price</label>
                                </div>
                                <div class="col-sm-1">
                                    <label class="form-check-label">Action</label>
                                </div>
                            </div>
                            <div id="formRow" class="form-group row">
                                <div class="col-sm-2">
                                    <select name="pname[]" class="form-control dynamic" data-dependent="godown" data-linked="unit" required>
                                        <option selected disabled>Please Select...</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select id="godown" name="godown[]" class="form-control" required>
                                        <option selected disabled>Please Select...</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input id="quantity" name="quantity[]" class="form-control calculable" data-dependent="price" data-linked="uprice" required>

                                    @error('quantity.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-1">
                                    <label id="unitLabel" class="form-check-label text-black-50"></label>
                                    <input type="text" id="unit" name="unit[]" data-output="unitLabel" hidden>
                                </div>
                                <div class="col-sm-2">
                                    <input id="unitp" name="uprice[]" class="form-control calculable-alt" data-dependent="price" data-linked="quantity" required>

                                    @error('uprice.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label id="priceLabel" class="form-check-label text-black-50">0</label>
                                    <input type="number" step="any" id="price" name="price[]" data-output="priceLabel" hidden>
                                </div>
                                <div class="col-sm-1">
                                    <button id="remove"  type="button" class="btn btn-danger btn-sm"><img src="{{asset('/icons/trash-2.svg')}}" alt="delete" width="15px"></button>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button id="add" type="button" class="btn btn-success btn-sm">Add Product</button>
                            <button id="confirm" type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="labour">Labour Cost</label>
                <input type="number" step="any" id="labour" name="labour" class="form-control main-form-input @error('labour') is-invalid @enderror" value="{{ old('labour') }}" required>

                @error('labour')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="transport">Transport Cost</label>
                <input type="number" step="any" id="transport" name="transport" class="form-control main-form-input @error('transport') is-invalid @enderror" value="{{ old('transport') }}" required>

                @error('transport')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-control-label">Subtotal:</label>
                <label id="subtotal" class="form-control-label float-right"></label>
                <input type="number" step="any" name="subtotal" hidden>
            </div>
            <div class="form-group">
                <label for="discount">Discount:</label>
                <input type="number" step="any" id="discount" name="discount" class="form-control main-form-input @error('discount') is-invalid @enderror" value="{{ old('discount') }}" required>

                @error('discount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-control-label">Grand Total:</label>
                <label id="gtotal" class="form-control-label float-right"></label>
                <input type="number" step="any" name="gtotal" hidden>
            </div>
            <div class="form-group">
                <label for="payment">Payment:</label>
                <label id="paid" class="form-control-label float-right">0</label>
                <button type="button" id="payment" class="btn btn-block btn-outline-dark" data-toggle="modal" data-target="#paymentModal">Add Payment</button>
            </div>

            <div class="modal fade" id="paymentModal">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-primary">Payment</h3>
                        </div>

                        <div id="body" class="modal-body font-weight-bold">
                            <div class="container-fluid m-auto">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                                        <option value="" selected disabled>Please Select...</option>
                                        <option value="Cash" @if(old('type')=="Cash") selected @endif>Cash</option>
                                        <option value="Cheque" @if(old('type')=="Cheque") selected @endif>Cheque</option>
                                        <option value="Card" @if(old('type')=="Cheque") selected @endif>Card</option>
                                    </select>

                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="confirm2" type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label">Due:</label>
                <label id="due" class="form-control-label float-right"></label>
                <input type="number" step="any" name="due" hidden>
            </div>
            <hr>
            <button type="submit" class="btn btn-success">Confirm</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning float-right">Cancel</a>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var count = 2;

        $(function() {
            var totalProductPrice;
            var transportCost = 0;
            var labourCost = 0;
            var discount = 0;
            var subTotal;
            var grandTotal;
            var paid = 0;
            var due;

            $('#confirm').click(function () {

                totalProductPrice = 0;
                transportCost = parseFloat($('#transport').val());
                labourCost = parseFloat($('#labour').val());
                discount = parseFloat( $('#discount').val());
                paid = parseFloat($('#amount').val());

                $('input[id*="price"]').each(function () {
                    totalProductPrice += parseFloat($(this).val());
                });
                subTotal = parseFloat(totalProductPrice + labourCost + transportCost) ;
                grandTotal = parseFloat(subTotal - discount);
                due = parseFloat(grandTotal - paid);

                $('input[name="subtotal"]').val(subTotal);
                $('#subtotal').html(subTotal);
                $('input[name="gtotal"]').val(grandTotal);
                $('#gtotal').html(grandTotal);
                $('#paid').html(paid);
                $('input[name="due"]').val(due);
                $('#due').html(due);
            });
            $(document).on('input', '.main-form-input', function () {

                transportCost = parseFloat($('#transport').val());
                labourCost = parseFloat($('#labour').val());
                discount = parseFloat( $('#discount').val());
                paid = parseFloat($('#amount').val());

                subTotal = parseFloat(totalProductPrice + labourCost + transportCost) ;
                grandTotal = parseFloat(subTotal - discount);
                due = parseFloat(grandTotal - paid);

                $('input[name="subtotal"]').val(subTotal);
                $('#subtotal').html(subTotal);
                $('input[name="gtotal"]').val(grandTotal);
                $('#gtotal').html(grandTotal);
                $('#paid').html(paid);
                $('input[name="due"]').val(due);
                $('#due').html(due);
            });
            $(document).on('click', '#confirm2', function () {

                transportCost = parseFloat($('#transport').val());
                labourCost = parseFloat($('#labour').val());
                discount = parseFloat( $('#discount').val());
                paid = parseFloat($('#amount').val());

                subTotal = parseFloat(totalProductPrice + labourCost + transportCost) ;
                grandTotal = parseFloat(subTotal - discount);
                due = parseFloat(grandTotal - paid);

                $('input[name="subtotal"]').val(subTotal);
                $('#subtotal').html(subTotal);
                $('input[name="gtotal"]').val(grandTotal);
                $('#gtotal').html(grandTotal);
                $('#paid').html(paid);
                $('input[name="due"]').val(due);
                $('#due').html(due);
            });
        });

        $('#add').click(function () {

            var element = `<div id="formRow" class="form-group row">
                                <div class="col-sm-2">
                                    <select name="pname[]" class="form-control dynamic" data-dependent="godown`+count+`" data-linked="unit`+count+`" required>
                                        <option selected disabled>Please Select...</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select id="godown`+count+`" name="godown[]" class="form-control" required>
                                        <option selected disabled>Please Select...</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input id="quantity`+count+`" name="quantity[]" class="form-control calculable" data-dependent="price`+count+`" data-linked="uprice`+count+`" required>
                                </div>
                                <div class="col-sm-1">
                                    <label id="unitLabel`+count+`" class="form-check-label text-black-50"></label>
                                    <input id="unit`+count+`" name="unit[]" data-output="unitLabel`+count+`" hidden>
                                </div>
                                <div class="col-sm-2">
                                    <input id="unitp`+count+`" name="uprice[]" class="form-control calculable-alt" data-dependent="price`+count+`" data-linked="quantity`+count+`" required>
                                </div>
                                <div class="col-sm-2">
                                    <label id="priceLabel`+count+`" class="form-check-label text-black-50">0</label>
                                    <input type="number" step="any" id="price`+count+`" name="price[]" data-output="priceLabel`+count+`" hidden>
                                </div>
                                <div class="col-sm-1">
                                    <button id="remove"  type="button" class="btn btn-danger btn-sm"><img src="`+inc+`" width="15px" alt="delete"></button>
                                </div>
                            </div>
                        </div>`;

            $('#body').append(element);

            $.each(products, function (index, product) {
                $('.dynamic:last').append('<option value="'+product.id+'">'+product.name+'</option>');
            });

            count++;
        });

        $(document).on('click', '#remove', function () {
            $(this).closest('#formRow').remove();
        });

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

        $(document).on('change', '.dynamic', function () {
            var p_id = $(this).val();
            var dependent = $(this).data('dependent');
            var unit = $(this).data('linked');
            $('#'+dependent).empty();
            $('#'+dependent).append('<option selected disabled>Please Select...</option>');
            if(p_id)
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('invoices.getGodowns')}}",
                    method:"POST",
                    data:{id:p_id, _token:_token},
                    success:function (response) {
                        $.each(response, function (index, godown) {
                            $('#'+dependent).append('<option value="'+godown.id+'">'+godown.name+' - '+godown.pivot.quantity+'</option>');
                        });
                    }
                });
            }
            getUnit(p_id, unit);
        });

        $(document).on('input', '.calculable', function () {
            var quantity = $(this).val();
            var linked = $(this).data('linked');
            var uprice = $('#'+linked).val();
            var dependent = $(this).data('dependent');
            var output = $('#'+dependent).data('output');

            if (quantity && uprice)
            {
                $('#'+output).html(quantity * uprice);
                $('#'+dependent).val(quantity * uprice);
            }
        });

        $(document).on('input', '.calculable-alt', function () {
            var uprice = $(this).val();
            var linked = $(this).data('linked');
            var quantity = $('#'+linked).val();
            var dependent = $(this).data('dependent');
            var output = $('#'+dependent).data('output');

            if (quantity && uprice)
            {
                $('#'+output).html(quantity * uprice);
                $('#'+dependent).val(quantity * uprice);
            }
        });

        function getUnit(id, field) {
            var _token = $('input[name="_token"]').val();
            var output = $('#'+field).data('output');
            $.ajax({
                url:"{{route('invoices.getUnit')}}",
                method:"POST",
                data:{id:id, _token:_token},
                success:function (response) {
                    $('#'+field).val(response);
                    $('#'+output).html(response);
                }
            });
        }
    </script>
@endsection
