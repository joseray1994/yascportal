<table class="table table-striped text-center" id="tag_container_detail">
    <thead class="text-white thead-yasc">
        <tr>
            <th>Operator</th>
            <th>Client</th>
            <th>Log in</th>
            <th>Log out</th>
            <th>Note</th>
            <th class="hidden-xs" >Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="usertype-list" class="table-data" >
        @forelse($data as $type)
        <tr id="usertype_id{{$type->id}}">
            <td>{{ $type->name }} {{ $type->lastname }}</td>
            <td>{{ $type->client }}</td>
            <td>{{ $type->time_s }}</td>
            <td>{{ $type->time_e }}</td>
            <td>adc</td>
            @switch($type->status)
                @case(1)
                    <td class="hidden-xs">
                        <span class='badge badge-success'>Activated</span>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Assignament Type" id="btn-edit" href="/assignmenttype/{{$type->id}}"  ><i class="fa fa-info-circle"></i></a>
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-type" data-toggle="tooltip" title="Deactivated" data-type="confirm" value="{{$type->id}}"><i class="fa fa-window-close"></i></button>
                    </td>
                @break
                @case(2)
                <td class="hidden-xs">
                    <span class='badge badge-secondary'>Deactivated</span>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-success off-type" title="Activated" data-toggle="tooltip" data-type="confirm" value="{{$type->id}}" ><i class="fa fa-check-square-o"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deletetype" data-toggle="tooltip" title="Delete" data-type="confirm" value="{{$type->id}}"><i class="fa fa-trash-o"></i></button>
                </td>
                @break
            @endswitch
        </tr>
        @empty
            <tr id="table-row" class="text-center">
                <th colspan="7" class="text-center">
                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                </th>
            </tr>
        @endforelse
    </tbody>
</table>

{!! $data->render() !!}