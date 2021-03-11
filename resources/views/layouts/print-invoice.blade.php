<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .borderless{
            border-left: 1px solid transparent !important;
            border-bottom: 1px solid transparent !important;
        }
        @media print {

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
            .btn{
                display: none;
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
                <h5><strong>{{ $invoice->client->name }}</strong></h5>
                <h6>{{ $invoice->client->phone }}</h6>
                <h6>{{ $invoice->client->address }}</h6>
                <h6>{{ $invoice->client->email }}</h6>
            </div>
            <div class="col-sm-2">
                <span class="float-right">{{ $invoice->sl_no }}</span>
                <br>
                <span class="float-right"><strong>{{ $invoice->date }}</strong></span>
                <br>
            </div>
        </div>
        <br>
        <div class="table-responsive-sm">
            <table class="table table-bordered" id="table" name="table">
                <thead class="thead-light">
                    <tr>
                        <th class="print">#</th>
                        <th class="print">Product</th>
                        <th class="print">Godown</th>
                        <th class="print">Quantity</th>
                        <th class="print">Unit</th>
                        <th class="print">Unit Price</th>
                        <th class="print">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($invoice->invoiceProducts as $product)
                    <tr>
                        <td class="print"> {{$loop->iteration}} </td>
                        <td class="print"> {{$product->product->name}} </td>
                        <td class="print"> {{$product->godown->name}} </td>
                        <td class="print"> {{$product->quantity}} </td>
                        <td class="print"> {{$product->unit}} </td>
                        <td class="print"> {{number_format($product->unit_selling_price, 2)}} </td>
                        <td class="print" style="text-align: right"> {{number_format($product->selling_price, 2)}} </td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="6" class="borderless print" style="text-align: right">Labour Cost</td>
                        <td class="print" style="text-align: right">{{ number_format($invoice->labour_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="borderless print" style="text-align: right">Transport Cost</td>
                        <td class="print" style="text-align: right">{{ number_format($invoice->transport_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="borderless print" style="text-align: right">Subtotal</td>
                        <td class="print" style="text-align: right">{{ number_format($invoice->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="borderless print" style="text-align: right">Discount</td>
                        <td class="print" style="text-align: right">{{ number_format($invoice->discount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="borderless print" style="text-align: right"><strong>Grand Total</strong></td>
                        <td class="print" style="text-align: right"><strong>{{ number_format($invoice->grand_total, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="borderless print" style="text-align: right">Paid</td>
                        <td class="print" style="text-align: right">{{ number_format($invoice->paid, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="borderless print" style="text-align: right">Due</td>
                        <td class="print" style="text-align: right">{{ number_format($invoice->due, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="borderless print" style="text-align: right">Previous Due</td>
                        <td class="print" style="text-align: right">{{ number_format($invoice->client->total_due - $invoice->due, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="borderless print" style="text-align: right"><strong>Total Due</strong></td>
                        <td class="print" style="text-align: right"><strong>{{ number_format($invoice->client->total_due, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
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
    $(document).on('click','#print',function () {
        window.print();
    });

    $(function(){
        window.onafterprint = function () {
            window.location.replace("{{route('admin.dashboard')}}");
        }
    });
</script>
</html>
