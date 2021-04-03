<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Title</th>
            <th>Description</th>
            <th>OPERATIONS</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($cashs as $cash)
        <tr>
            <td> {{$loop->iteration}} </td>
            <td> {{$cash->type}} </td>
            <td> {{number_format($cash->amount, 2)}} </td>
            <td> {{$cash->date}} </td>
            <td> {{$cash->title}} </td>
            <td> {{$cash->description}} </td>
            <td class="d-flex justify-content-center">
                @auth('admin')
                    @if($slot == 'trash')
                        <form action="{{route('admin.cash-register.restore', $cash)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm mr-1" title="restore"><span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span></button>
                        </form>
                    @endif
                    <button class="btn @if($slot == 'trash') btn-danger @else btn-warning @endif btn-sm" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                        <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                    </button>
                    @component('layouts.components.delete-modal')
                        @if($slot == 'trash')
                            action="{{route('admin.cash-register.force.delete', $cash)}}"
                        @else
                            action="{{route('admin.cash-register.destroy', $cash)}}"
                        @endif
                        @slot('loop') {{$loop->index}} @endslot
                    @endcomponent
                @endauth
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
