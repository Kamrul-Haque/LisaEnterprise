<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Sl No.</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Godown From</th>
            <th>Godown To</th>
            <th>Date</th>
            <th>Entry by</th>
            @auth('admin')
                <th class="text-center">OPERATIONS</th>
            @endauth
        </tr>
    </thead>
    <tbody>
    @foreach ($productTransfers as $transfer)
        <tr>
            <td> {{$loop->iteration}} </td>
            <td> {{$transfer->sl_no}} </td>
            <td> {{$transfer->product->name}} </td>
            <td> {{$transfer->quantity}} </td>
            <td> {{$transfer->godownFrom->name}} </td>
            <td> {{$transfer->godownTo->name}} </td>
            <td> {{$transfer->date}} </td>
            <td> {{$transfer->entry_by}} </td>
            @auth('admin')
                <td>
                    <div class="row justify-content-center">
                        @auth('admin')
                            @if($slot == 'trash')
                                <form action="{{route('admin.product-transfers.restore', $transfer)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm mr-1" title="restore"><span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span></button>
                                </form>
                            @endif
                            <button class="btn @if($slot == 'trash') btn-danger @else btn-warning @endif btn-sm" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                                <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                            </button>
                            @component('layouts.components.delete-modal')
                                @if($slot == 'trash')
                                    action="{{route('admin.product-transfers.force.delete', $transfer)}}"
                                @else
                                    action="{{route('admin.product-transfers.destroy', $transfer)}}"
                                @endif
                                @slot('loop') {{$loop->index}} @endslot
                            @endcomponent
                        @endauth
                    </div>
                </td>
            @endauth
        </tr>
    @endforeach
    </tbody>
</table>
