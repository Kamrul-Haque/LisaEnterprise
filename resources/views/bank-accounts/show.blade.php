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
    </style>
    @if(Auth::guard('admin')->check())
        <style>
            th{
                background-color: #23272b;
                color: whitesmoke;
            }
        </style>
    @else
        <style>
            th{
                background-color: #3490dc;
                color: whitesmoke;
            }
        </style>
    @endif
@endsection
@section('content')
    <div class="container-fluid pl-5 pr-5">
        <div class="form-group row pb-0">
            <div class="col-md-4">
                <a class="btn btn-light float-left" href=" {{route('bank-account.index')}} ">Back</a>
            </div>
            <div class="col-md-4 justify-content-center" style="padding-left: 100px">
                <h2>Client History</h2>
            </div>
            <div class="col-sm-4">
                <button id="withdraw" type="button" class="btn btn-outline-danger float-right ml-1">Withdraws</button>
                <button id="deposit" type="button" class="btn btn-outline-success float-right">Deposits</button>
            </div>
        </div>
        <hr>
        <h5>Bank Name: {{ $bankAccount->bank_name }}</h5>
        <h5>Branch: {{ $bankAccount->branch }}</h5>
        <h5>Account Number: {{ $bankAccount->account_no}}</h5>
        <br>
        <div class="card card-body bg-light">
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover" id="depositTable">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Cheque No.</th>
                        <th>Card No.</th>
                        <th>Validity</th>
                        <th>CVV</th>
                        <th>Amount</th>
                        <th>Date Issued</th>
                        <th>Date Drawn</th>
                        <th>Entry By</th>
                        <th>Status</th>
                        <th class="text-center">OPERATION</th>
                    </tr>
                    <tbody>
                    @foreach ($bankAccount->bankDeposits as $deposit)
                        <tr>
                            <td> {{$loop->index + 1}} </td>
                            <td> {{$deposit->type}} </td>
                            <td> {{$deposit->cheque_no}} </td>
                            <td> {{$deposit->card_no}} </td>
                            <td> {{$deposit->validity}} </td>
                            <td> {{$deposit->cvv}} </td>
                            <td> {{$deposit->amount}} </td>
                            <td> {{$deposit->date_of_issue}} </td>
                            <td> {{$deposit->date_of_draw}} </td>
                            <td> {{$deposit->entry_by}} </td>
                            <td> {{$deposit->status}} </td>
                            <td class="text-center">
                                @if($deposit->status == 'Pending')
                                <a href="{{ route('bank-deposit.status.edit', $deposit) }}" class="btn btn-outline-primary btn-sm">Change Status</a>
                                @endif
                                @if(Auth::guard('admin')->check())
                                    <form class="d-inline-block" action="{{route('bank-deposit.destroy', $deposit)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning btn-sm ml-1" title="delete"><span data-feather="trash-2" style="width: 15px; height: 15px; padding: 0"></span></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table class="table table-striped table-hover" id="withdrawTable">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Cheque No.</th>
                        <th>Card No.</th>
                        <th>Validity</th>
                        <th>CVV</th>
                        <th>Amount</th>
                        <th>Date Issued</th>
                        <th>Date Drawn</th>
                        <th>Entry By</th>
                        <th class="text-center">OPERATION</th>
                    </tr>
                    <tbody>
                    @foreach ($bankAccount->bankWithdraws as $withdraw)
                        <tr>
                            <td> {{$loop->index + 1}} </td>
                            <td> {{$withdraw->type}} </td>
                            <td> {{$withdraw->cheque_no}} </td>
                            <td> {{$withdraw->card_no}} </td>
                            <td> {{$withdraw->validity}} </td>
                            <td> {{$withdraw->cvv}} </td>
                            <td> {{$withdraw->amount}} </td>
                            <td> {{$withdraw->date_of_issue}} </td>
                            <td> {{$withdraw->date_of_draw}} </td>
                            <td> {{$withdraw->entry_by}} </td>
                            <td class="text-center">
                                @if($withdraw->status == 'Pending')
                                    <a href="{{ route('bank-withdraw.status.edit', $withdraw) }}" class="btn btn-outline-primary btn-sm">Change Status</a>
                                @endif
                                @if(Auth::guard('admin')->check())
                                    <form class="d-inline-block" action="{{ route('bank-withdraw.destroy', $withdraw) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning btn-sm" title="delete"><span data-feather="trash-2" style="width: 15px; height: 15px; padding: 0"></span></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
    </div>
    <script type="text/javascript">
        $(function () {
            window.onafterprint = function () {
                window.location.replace("{{route('admin.dashboard')}}");
            }
            $('#withdrawTable').hide();
        });
        $(document).on('click', '#deposit', function () {
            $('#withdrawTable').hide();
            $('#depositTable').show();
        });
        $(document).on('click', '#withdraw', function () {
            $('#depositTable').hide();
            $('#withdrawTable').show();
        });
    </script>
@endsection
