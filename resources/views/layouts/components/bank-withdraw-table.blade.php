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
    @foreach ($bankWithdraws as $withdraw)
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
            <td> {{$withdraw->status}} </td>
            <td class="d-flex justify-content-center">
                @if($withdraw->status == 'Pending')
                    <a href="{{ route('bank-withdraw.status.edit', $withdraw) }}" class="btn btn-outline-primary btn-sm">Change Status</a>
                @endif
                @auth('admin')
                    @if($slot == 'trash')
                        <form action="{{route('admin.bank-withdraw.restore', $withdraw)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm mr-1" title="restore"><span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span></button>
                        </form>
                    @endif
                    <button class="btn @if($slot == 'trash') btn-danger @else btn-warning @endif btn-sm" title="delete" data-toggle="modal" data-target="#deleteWithdraw{{$loop->index}}">
                        <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                    </button>
                    @component('layouts.components.delete-modal')
                        @if($slot == 'trash')
                            action="{{ route('admin.bank-withdraw.force.delete', $withdraw) }}"
                        @else
                            action="{{ route('admin.bank-withdraw.destroy', $withdraw) }}"
                        @endif
                        @slot('loop') Withdraw{{$loop->index}} @endslot
                    @endcomponent
                @endauth
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
