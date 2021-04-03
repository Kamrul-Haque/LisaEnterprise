<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>PHONE</th>
            <th>ADDRESS</th>
            <th>Total Due</th>
            <th>Total Purchase</th>
            <th class="text-center">OPERATIONS</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($clients as $client)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td> {{$client->name}} </td>
            <td> {{$client->email}} </td>
            <td> {{$client->phone}} </td>
            <td> {{$client->address}} </td>
            <td> {{$client->total_due}} </td>
            <td> {{$client->total_purchase}} </td>
            <td>
                <div class="row justify-content-center">
                    @if($slot == 'trash')
                        <form action="{{route('admin.clients.restore',$client)}}" method="post">
                            @csrf
                            <button class="btn btn-success btn-sm" title="restore">
                                <span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span>
                            </button>
                        </form>
                    @else
                        <a href="{{route('clients.show',$client)}}" class="btn btn-dark btn-sm" title="client history"><span data-feather="eye" style="height: 15px; width: 15px; padding: 0"></span></a>
                        <div class="ml-1">
                            <a href="{{route('clients.edit',$client)}}" class="btn btn-primary btn-sm" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                        </div>
                    @endif
                    @auth('admin')
                        <button class="btn @if($slot == 'trash') btn-danger @else btn-warning @endif btn-sm ml-1" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                        </button>
                        @component('layouts.components.delete-modal')
                            @if($slot == 'trash')
                                action="{{route('admin.clients.force-delete', $client)}}"
                            @else
                                action="{{route('admin.clients.destroy', $client)}}"
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
