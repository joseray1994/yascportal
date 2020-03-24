<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            <th width="100px">ID</th>
            <th>Departament</th>
			<th>Provider</th>
            <th>Name</th>
            <th>Quantity</th>
			<th>Price</th>
			<th>Cost</th>
			<th>Total Price</th>
            <th class="hidden-xs" >Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="supply-list">
        @forelse ($data as $supply)
        <tr id="supply_id{{$supply->id}}" class="rowType">
            <td>{{ $supply->id }}</td>
			<td>{{ $supply->id_department }}</td>
			<td>{{ $supply->name_prov }}</td>
            <td>{{ $supply->name }}</td>
            <td>{{ $supply->quantity }}</td>
            <td> $ {{number_format($supply->price, 2)}}</td>
			<td> $ {{number_format($supply->cost, 2)}}</td>
			<td> $ {{number_format($supply->total_price, 2)}}</td>
            @switch($supply->status)
                @case(1)
                    <td class="hidden-xs">
                        <span class='badge badge-success'>Activated</span>
                    </td>
                    <td>
                        <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="{{$supply->id}}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert off-supply" title="Deactivated" data-type="confirm" value="{{$supply->id}}"><i class="fa fa-window-close"></i></button>
                    </td>
                @break
                @case(2)
                <td class="hidden-xs">
                    <span class='badge badge-secondary'>Deactivated</span>
                </td>
                <td>
                    <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-success off-supply" title="Activated" data-type="confirm" value="{{$supply->id}}" ><i class="fa fa-check-square-o"></i></button>
                    <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert delete-supply" title="Delete" data-type="confirm" value="{{$supply->id}}"><i class="fa fa-trash-o"></i></button>
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
