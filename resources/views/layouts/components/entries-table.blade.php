<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Sl No.</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Godown</th>
            <th>Date</th>
            <th>Bought From</th>
            <th>Entry by</th>
            <th>Total Price</th>
            <th>Paid</th>
            <th>Due</th>
            @auth('admin')
                <th class="text-center">OPERATIONS</th>
            @endauth
        </tr>
    </thead>
    <tbody>
    @foreach ($entries as $entry)
        <tr>
            <td> {{$loop->iteration}} </td>
            <td> {{$entry->sl_no}} </td>
            <td> {{$entry->product->name}} </td>
            <td> {{$entry->quantity}} {{$entry->unit}}</td>
            <td> {{$entry->godown->name}} </td>
            <td> {{$entry->date}} </td>
            <td> {{$entry->supplier->name}} </td>
            <td> {{$entry->entry_by}} </td>
            <td> {{$entry->buying_price}} </td>
            <td> {{$entry->paid}} </td>
            <td> {{$entry->due}} </td>
            @auth('admin')
                <td>
                    <div class="row justify-content-center">
                        @if($slot == 'trash')
                            <form action="{{ route('admin.entries.restore', $entry) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span>
                                </button>
                            </form>
                        @endif
                        <button class="btn @if($slot == 'trash') btn-danger @else btn-warning @endif btn-sm ml-1" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                        </button>
                        @component('layouts.components.delete-modal')
                            @if($slot == 'trash')
                                action="{{route('admin.entries.force.delete', $entry)}}"
                            @else
                                action="{{route('admin.entries.destroy', $entry)}}"
                            @endif
                            @slot('loop') {{$loop->index}} @endslot
                        @endcomponent
                    </div>
                </td>
            @endauth
        </tr>
    @endforeach
    </tbody>
</table>
