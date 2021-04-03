<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Account No.</th>
            <th>Bank Name</th>
            <th>Branch</th>
            <th>Balance</th>
            <th class="text-center">Operations</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($bankAccounts as $bankAccount)
        <tr>
            <td> {{$loop->index + 1}} </td>
            <td> {{$bankAccount->account_no}} </td>
            <td> {{$bankAccount->bank_name}} </td>
            <td> {{$bankAccount->branch}} </td>
            <td> {{$bankAccount->balance}} </td>
            <td>
                <div class="row justify-content-center">
                    @if($slot == 'trash')
                        <form action="{{route('admin.bank-account.restore', $bankAccount)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm mr-1" title="restore"><span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span></button>
                        </form>
                    @else
                        <a href="{{route('bank-account.show',$bankAccount)}}" class="btn btn-dark btn-sm" title="client history"><span data-feather="eye" style="height: 15px; width: 15px; padding: 0"></span></a>
                        <div class="pl-1">
                            <a href="{{route('bank-account.edit',$bankAccount)}}" class="btn btn-primary btn-sm" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                        </div>
                    @endif
                    @auth('admin')
                        <button class="btn @if($slot == 'trash') btn-danger @else btn-warning @endif btn-sm ml-1" name="delete" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                        </button>
                        @component('layouts.components.delete-modal')
                            @if($slot == 'trash')
                                action="{{route('admin.bank-account.force.delete', $bankAccount)}}"
                            @else
                                action="{{route('admin.bank-account.destroy', $bankAccount)}}"
                            @endif
                            @slot('loop') {{$loop->index}} @endslot
                        @endcomponent
                    @endauth
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
