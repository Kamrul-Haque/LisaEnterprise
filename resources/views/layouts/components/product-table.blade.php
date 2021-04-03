<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>NAME</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th class="text-center">OPERATIONS</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($products as $product)
        <tr>
            <td> {{$loop->iteration}} </td>
            <td> {{$product->name}} </td>
            <td> {{$product->totalQuantity()}} </td>
            <td> {{$product->unit}} </td>
            <td>
                <div class="row justify-content-center">
                    @if($slot == 'product')
                    <a href="{{route('products.edit', $product)}} " class="btn btn-primary btn-sm" title="edit">
                        <span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span>
                    </a>
                    @else
                    <form action="{{ route('admin.products.restore', $product) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" title="restore"><span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span></button>
                    </form>
                    @endif
                    @auth('admin')
                        <button class="btn @if($slot == 'product') btn-warning @else btn-danger @endif btn-sm ml-1" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                        </button>
                    @endauth
                </div>
            </td>
        </tr>
        @component('layouts.components.delete-modal')
            @if($slot == 'product')
                action="{{ route('admin.products.destroy', $product) }}"
            @else
                action="{{ route('admin.products.force.delete', $product) }}"
            @endif
            @slot('loop') {{$loop->index}} @endslot
        @endcomponent
    @endforeach
    </tbody>
</table>
