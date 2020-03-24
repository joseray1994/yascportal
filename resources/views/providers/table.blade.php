<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            <th width="100px">ID</th>
			<th>Departamento</th>
            <th>Name</th>
            <th>RFC</th>
			<th>Phone</th>
			<th>email</th>
            <th class="hidden-xs" >Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="provider-list">
        @forelse ($data as $provider)
        <tr id="provider_id{{$provider->id}}" class="rowType">
            <td>{{ $provider->id }}</td>
			<td>{{ $provider->id_department }}</td>
            <td>{{ $provider->name }}</td>
            <td>{{ $provider->rfc }}</td>
			<td>{{ $provider->phone }}</td>
			<td>{{ $provider->email }}</td>
            @switch($provider->status)
                @case(1)
                    <td class="hidden-xs">
                        <span class='badge badge-success'>Activated</span>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="See Suppplies" href="{{ action('SupplyController@index', ['id' => $provider->id]) }}"><i class="fa fa-cubes"></i></a>
                        <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="{{$provider->id}}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert off-provider" title="Deactivated" data-type="confirm" value="{{$provider->id}}"><i class="fa fa-window-close"></i></button>
                    </td>
                @break
                @case(2)
                <td class="hidden-xs">
                    <span class='badge badge-secondary'>Deactivated</span>
                </td>
                <td>
                    <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-success off-provider" title="Activated" data-type="confirm" value="{{$provider->id}}" ><i class="fa fa-check-square-o"></i></button>
                    <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert delete-provider" title="Delete" data-type="confirm" value="{{$provider->id}}"><i class="fa fa-trash-o"></i></button>
                </td>
                @break
            @endswitch
        </tr>
        @empty
            <tr id="table-row" class="text-center">
                <th colspan="8" class="text-center">
                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                </th>
            </tr>
        @endforelse
    </tbody>
</table>


{!! $data->render() !!}
