<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script>var products = {!! $products !!}</script>
    <script>var inc = '{{ asset('icons/trash-2.svg') }}' </script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
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
        .borderless{
            border-left: 1px solid transparent !important;
            border-bottom: 1px solid transparent !important;
        }
        @media print {
            input{
                border: 0;
                text-align: right;
            }
            select{
                border: 0;
                appearance: none;
            }
            .btn{
                display: none;
            }
            .unstyled::-webkit-inner-spin-button,
            .unstyled::-webkit-calendar-picker-indicator {
                display: none;
                -webkit-appearance: none;
            }
            th.print{
                border: 1px solid black !important;
            }
            td.print{
                border: 1px solid black !important;
            }
            td.borderless{
                border-left: 1px solid transparent !important;
                border-bottom: 1px solid transparent !important;
            }
            .print-bottom{
                position: fixed;
                bottom: 0;
            }
            hr.line {
                border: 1px solid black;
            }
        }
    </style>
</head>
<body>
<div class="container pt-3">
    <img src="{{asset('images/invoice-banner.png')}}" title="Lisa Enterprise" width="100%">
    <hr class="line">
    <div class="row">
        <div class="col-sm-10">
        <h5>Client:</h5>
        <select id="name" name="name" required>
            <option value="" selected disabled>Please Select...</option>
            @foreach ($clients as $client)
                <option value="{{$client->id}}">{{$client->name}}</option>
            @endforeach
        </select>
        </div>
        <div class="col-sm-2">
        <span class="float-right"><input type="date" id="date" class="unstyled" name="date" required></span>
        </div>
    </div>
    <br>
    <div class="table-responsive-sm">
        <table class="table table-bordered" id="table" name="table">
            <thead class="thead-light">
            <tr>
                <th class="print">#</th>
                <th class="print">Product</th>
                <th class="print">Quantity</th>
                <th class="print">Unit</th>
                <th class="print">Unit Price</th>
                <th class="print">Total Price</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="print">
                        <button id="remove" class="btn btn-sm btn-warning"><img src="{{asset('icons/trash-2.svg')}}"></button><span class="pl-2">1</span>
                    </td>
                    <td class="print">
                        <select name="pname[]" class="dynamic" data-dependent="godown" data-linked="unitLabel">
                            <option selected disabled>Please Select...</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="print">
                        <input type="number" step="any" id="quantity" class="form-input calculable" data-dependent="price" data-linked="uprice">
                    </td>
                    <td class="print">
                        <select class="unit" name="unit[]">
                            <option selected disabled>Please Select...</option>
                            @foreach($products as $product)
                                <option>{{ $product->unit }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="print">
                        <input type="number" step="any" id="uprice" class="form-input calculable-alt" data-dependent="price" data-linked="quantity">
                    </td>
                    <td class="print" style="text-align: right">
                        <label id="price">0</label>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="borderless print" style="text-align: right">Labour Cost</td>
                    <td class="print" style="text-align: right"><input type="number" step="any" id="labour" name="labour" class="form-input" required></td>
                </tr>
                <tr>
                    <td colspan="5" class="borderless print" style="text-align: right">Transport Cost</td>
                    <td class="print" style="text-align: right"><input type="number" step="any" id="transport" name="transport" class="form-input" required></td>
                </tr>
                <tr>
                    <td colspan="5" class="borderless print" style="text-align: right">Subtotal</td>
                    <td class="print" style="text-align: right"><label id="subtotal" class="float-right">0</label></td>
                </tr>
            </tfoot>
        </table>
        <button id="add" type="button" class="btn btn-block btn-outline-secondary">Add Product</button>
        <div class="row pt-3">
            <div class="col-md-6">
                <button id="print" type="button" class="btn btn-block btn-info"><span data-feather="printer" style="height: 15px; width: 15px; padding: 0"></span>Print</button>
            </div>
            <div class="col-md-6">
                <a type="button" class="btn btn-block btn-warning" href="{{url()->previous()}}">Cancel</a>
            </div>
        </div>
    </div>
    <br>
    <div class="container print-bottom">
        <p>-------------------------<br>Authorization Signature</p>
    </div>
</div>
</body>
<script>
    feather.replace();
</script>
<script type="text/javascript">
    var count = 2;

    $(document).on('click','#print',function () {
        window.print();
    });

    $(function() {
        var totalProductPrice;
        var transportCost = 0;
        var labourCost = 0;
        var subTotal;

        $(document).on('input', '.form-input', function () {
            totalProductPrice = 0;
            transportCost = parseFloat($('#transport').val());
            labourCost = parseFloat($('#labour').val());

            $('label[id*="price"]').each(function () {
                totalProductPrice += parseFloat($(this).html());
            });

            subTotal = parseFloat(totalProductPrice + labourCost + transportCost);
            $('#subtotal').html(subTotal);
        });

        window.onafterprint = function () {
            window.location.replace("{{route('admin.dashboard')}}");
        }
    });

    $(document).on('input', '.calculable', function () {
        var quantity = $(this).val();
        var linked = $(this).data('linked');
        var uprice = $('#'+linked).val();
        var dependent = $(this).data('dependent');

        if (quantity && uprice)
        {
            $('#'+dependent).html(quantity * uprice);
        }
    });

    $(document).on('input', '.calculable-alt', function () {
        var uprice = $(this).val();
        var linked = $(this).data('linked');
        var quantity = $('#'+linked).val();
        var dependent = $(this).data('dependent');

        if (quantity && uprice)
        {
            $('#'+dependent).html(quantity * uprice);
        }
    });

    $('#add').click(function () {

        var element = `<tr>
                    <td class="print">
                        <button id="remove" class="btn btn-sm btn-warning"><img src="`+inc+`"></button><span class="pl-2">`+count+`</span>
                    </td>
                    <td class="print">
                        <select class="dynamic">
                            <option selected disabled>Please Select...</option>
                        </select>
                    </td>
                    <td class="print">
                        <input type="number" step="any" id="quantity`+count+`" class="form-input calculable" data-dependent="price`+count+`" data-linked="uprice`+count+`">
                    </td>
                    <td class="print">
                        <select class="unit">
                            <option selected disabled>Please Select...</option>
                        </select>
                    </td>
                    <td class="print">
                        <input type="number" step="any" id="uprice`+count+`" class="form-input calculable-alt" data-dependent="price`+count+`" data-linked="quantity`+count+`">
                    </td>
                    <td class="print" style="text-align: right">
                        <label id="price`+count+`">0</label>
                    </td>
                </tr>`;

        $('tbody').append(element);

        $.each(products, function (index, product) {
            $('.dynamic:last').append('<option value="'+product.id+'">'+product.name+'</option>');
            $('.unit:last').append('<option>'+product.unit+'</option>');
        });

        count++;
    });

    $(document).on('click', '#remove', function () {
        $(this).closest('tr').remove();
    });
</script>
</html>
