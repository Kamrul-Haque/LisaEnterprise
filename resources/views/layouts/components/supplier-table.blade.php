<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>PHONE</th>
            <th>ADDRESS</th>
            <th>TOTAL DUE</th>
            <th>TOTAL PAID</th>
            <th class="text-center">OPERATIONS</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($suppliers as $supplier)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td> {{$supplier->name}} </td>
            <td> {{$supplier->email}} </td>
            <td> {{$supplier->phone}} </td>
            <td> {{$supplier->address}} </td>
            <td> {{$supplier->total_due}} </td>
            <td> {{$supplier->total_paid}} </td>
            <td>
                <div class="row justify-content-center">
                    @if($slot == 'supplier')
                    <a href="{{route('suppliers.show',$supplier)}}" class="btn btn-dark btn-sm" title="client history"><span data-feather="eye" style="height: 15px; width: 15px; padding: 0"></span></a>
                    <div class="ml-1">
                        <a href="{{route('suppliers.edit',$supplier)}}" class="btn btn-primary btn-sm" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                    </div>
                    @else
                    <form action="{{route('admin.suppliers.restore',$supplier)}}" method="post">
                        @csrf
                        <button class="btn btn-success btn-sm ml-1" title="restore"><span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span></button>
                    </form>
                    @endif
                    @auth('admin')
                        <button class="btn @unless($slot == 'supplier') btn-danger @else btn-warning @endunless btn-sm ml-1" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                        </button>
                        @component('layouts.components.delete-modal')
                            @if($slot == 'supplier')
                                action="{{route('admin.suppliers.destroy', $supplier)}}"
                            @else
                                action="{{route('admin.suppliers.force.delete', $supplier)}}"
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

