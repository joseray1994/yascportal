<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
         <tr>
            <th>Vacante</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Mail</th>
            <th>Channel</th>
            <th class="hidden-xs" >Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody  id="candidate-list" style="word-break: break-word; ">
        @forelse ($data as $candidate)
        <tr  id="candidate_id{{$candidate->id}}" class="rowType">
			<td>{{ $candidate->name_vacancy }}</td>
            <td>{{ $candidate->name}} {{ $candidate->last_name}}</td>
            <td>{{ $candidate->phone }}</td>
            <td>{{ $candidate->mail }}</td>
            <td style=" white-space: normal !important; word-wrap: break-word;">{{ $candidate->channel }}</td>
             @switch($candidate->status)
                @case(1)
                    <td class="hidden-xs">
                        <span class='badge badge-success'>Activated</span>
                    </td>
                    <td>
                        <button type="button"  data-toggle="tooltip" class="btn btn-sm btn-outline-primary  info_modal" title="Qualification" id="btn-info" value="{{$candidate->id}}"  ><i class="fa fa-info-circle"></i></button>
                        <button type="button"  data-toggle="tooltip" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="{{$candidate->id}}"  ><i class="fa fa-edit"></i></button>
                        <button type="button"  data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert off-candidate" title="Deactivated" data-type="confirm" value="{{$candidate->id}}"><i class="fa fa-window-close"></i></button>
                        <button type="button"  data-toggle="tooltip" class="btn btn-sm btn-outline-secondary open-documents" onclick="openDocument('{{$candidate->id}}')" data-toggle="tooltip" title="Documents" value="{{$candidate->id}}"><i class="fa  fa-folder-open"></i></button>

                    </td>
                @break
                @case(2)
                <td class="hidden-xs">
                    <span class='badge badge-secondary'>Deactivated</span>
                </td>
                <td>
                    <button type="button"  data-toggle="tooltip" class="btn btn-sm btn-outline-primary  info_modal" title="Qualification" id="btn-info" value="{{$candidate->id}}"  ><i class="fa fa-info-circle"></i></button>
                    <button type="button"  data-toggle="tooltip" class="btn btn-sm btn-outline-success off-candidate" title="Activated" data-type="confirm" value="{{$candidate->id}}" ><i class="fa fa-check-square-o"></i></button>
                    <button type="button"  data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert delete-candidate" title="Delete" data-type="confirm" value="{{$candidate->id}}"><i class="fa fa-trash-o"></i></button>
                    <button type="button"  data-toggle="tooltip" class="btn btn-sm btn-outline-secondary open-documents" onclick="openDocument('{{$candidate->id}}')" data-toggle="tooltip" title="Documents" value="{{$candidate->id}}"><i class="fa  fa-folder-open"></i></button>
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