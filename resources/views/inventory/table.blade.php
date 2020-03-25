<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            <th width="100px">ID</th>
            <th>Provider</th>
            <th>Supply</th>
			<th>Quantity</th>
			<th>Purchase Price</th>
			<th>Sale price</th>
			<th>Total Price</th>
            <th class="hidden-xs" >Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="inventory-list">
        @forelse ($data as $inventory)
        <tr id="inventory_id{{$inventory->id}}" class="rowType">
            <td>{{ $inventory->id }}</td>
			<td>{{ $inventory->name_prov }}</td>
            <td>{{ $inventory->name }}</td>
            <td>{{ $inventory->quantity }}</td>
            <td> $ {{number_format($inventory->price, 2)}}</td>
			<td> $ {{number_format($inventory->cost, 2)}}</td>
			<td> $ {{number_format($inventory->total_price, 2)}}</td>
            @switch($inventory->status)
                @case(1)
                    <td class="hidden-xs">
                        <span class='badge badge-success'>Activated</span>
                    </td>
                    <td>
                        <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="{{$inventory->id}}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert off-inventory" title="Deactivated" data-type="confirm" value="{{$inventory->id}}"><i class="fa fa-window-close"></i></button>
                    </td>
                @break
                @case(2)
                <td class="hidden-xs">
                    <span class='badge badge-secondary'>Deactivated</span>
                </td>
                <td>
                    <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-success off-inventory" title="Activated" data-type="confirm" value="{{$inventory->id}}" ><i class="fa fa-check-square-o"></i></button>
                    <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert delete-inventory" title="Delete" data-type="confirm" value="{{$inventory->id}}"><i class="fa fa-trash-o"></i></button>
                </td>
                @break
            @endswitch
        </tr>
        @empty
            <tr id="table-row" class="text-center">
                <th colspan="10" class="text-center">
                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                </th>
            </tr>
        @endforelse
    </tbody>
</table>


{!! $data->render() !!}
