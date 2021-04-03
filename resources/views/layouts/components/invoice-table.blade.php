<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>SL NO.</th>
            <th>Date</th>
            <th>Client Name</th>
            <th>Labour Cost</th>
            <th>Transport Cost</th>
            <th>Subtotal</th>
            <th>Discount</th>
            <th>Grand Total</th>
            <th>Paid</th>
            <th>Due</th>
            <th>Sold By</th>
            <th class="text-center">OPERATIONS</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($invoices as $invoice)
        <tr>
            <td> {{$loop->iteration}} </td>
            <td> {{$invoice->sl_no}} </td>
            <td> {{$invoice->date}} </td>
            <td> {{$invoice->client->name}} </td>
            <td> {{$invoice->labour_cost}} </td>
            <td> {{$invoice->transport_cost}} </td>
            <td> {{$invoice->subtotal}} </td>
            <td> {{$invoice->discount}}</td>
            <td> {{$invoice->grand_total}} </td>
            @if($invoice->clientPayment->status != 'N/A')
                <td> {{$invoice->paid}}({{$invoice->clientPayment->status}}) </td>
            @else
                <td>{{$invoice->paid}}</td>
            @endif
            <td> {{$invoice->due}} </td>
            <td> {{$invoice->sold_by}} </td>
            <td>
                <div class="row justify-content-center">
                    @if($slot == 'trash')
                        <form action="{{route('admin.invoices.restore',$invoice)}}" method="post">
                            @csrf
                            <button class="btn btn-success btn-sm" title="restore">
                                <span data-feather="rotate-ccw" style="height: 15px; width: 15px; padding: 0"></span>
                            </button>
                        </form>
                    @else
                        <a href="{{route('invoices.show', $invoice)}}" class="btn d-block btn-dark btn-sm" title="details"><span data-feather="eye" style="height: 15px; width: 15px; padding: 0"></span></a>
                    @endif
                    @auth('admin')
                        <button class="btn @if($slot == 'trash') btn-danger @else btn-warning @endif btn-sm ml-1" title="delete" data-toggle="modal" data-target="#delete{{$loop->index}}">
                            <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                        </button>
                        @component('layouts.components.delete-modal')
                            @if($slot == 'trash')
                                action="{{route('admin.invoices.force.delete', $invoice)}}"
                            @else
                                action="{{route('admin.invoices.destroy', $invoice)}}"
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
