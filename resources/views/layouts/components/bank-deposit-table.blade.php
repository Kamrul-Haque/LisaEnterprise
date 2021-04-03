<table class="table table-bordered table-striped">
    <thead class="thead-dark">
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
    </thead>
    <tbody>
    @foreach ($bankDeposits as $deposit)
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
            <td class="d-flex justify-content-center">
                @if($deposit->status == 'Pending')
                    <a href="{{ route('bank-deposit.status.edit', $deposit) }}" class="btn btn-outline-primary btn-sm">Change Status</a>
                @endif
                @auth('admin')
                    @if($slot == 'trash')
                        <form action="{{route('admin.bank-deposit.restore', $deposit)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm mr-1" title="restore"><span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span></button>
                        </form>
                    @endif
                    <button class="btn @if($slot == 'trash') btn-danger @else btn-warning @endif btn-sm" title="delete" data-toggle="modal" data-target="#deleteDeposit{{$loop->index}}">
                        <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                    </button>
                    @component('layouts.components.delete-modal')
                        @if($slot == 'trash')
                            action="{{ route('admin.bank-deposit.force.delete', $deposit) }}"
                        @else
                            action="{{ route('admin.bank-deposit.destroy', $deposit) }}"
                        @endif
                        @slot('loop') Deposit{{$loop->index}} @endslot
                    @endcomponent
                @endauth
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
