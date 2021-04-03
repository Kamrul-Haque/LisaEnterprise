<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>NAME</th>
            <th>Location</th>
            <th>PHONE</th>
            <th class="text-center">OPERATIONS</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($godowns as $godown)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td> {{$godown->name}} </td>
            <td> {{$godown->location}} </td>
            <td> {{$godown->phone}} </td>
            <td>
                <div class="row justify-content-center">
                    @if($slot == 'trash')
                        <form action="{{route('admin.godowns.restore',$godown)}}" method="post">
                            @csrf
                            <button class="btn btn-success btn-sm" title="restore">
                                <span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span>
                            </button>
                        </form>
                    @else
                        <a href="{{route('godowns.show',$godown)}}" class="btn btn-dark btn-sm" title="client history"><span data-feather="eye" style="height: 15px; width: 15px; padding: 0"></span></a>
                        <div class="ml-1">
                            <a href="{{route('godowns.edit',$godown)}}" class="btn btn-primary btn-sm" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                        </div>
                    @endif
                    @auth('admin')
                        <button class="btn @if($slot == 'trash') btn-danger @else btn-warning @endif btn-sm ml-1" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                        </button>
                        @component('layouts.components.delete-modal')
                            @if($slot == 'trash')
                                action="{{route('admin.godowns.force.delete', $godown)}}"
                            @else
                                action="{{route('admin.godowns.destroy', $godown)}}"
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
