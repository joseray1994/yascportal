<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            <th>Vacante</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Mail</th>
            <th>Channel</th>
            <th>Listening Test</th>
            <th>Grammar Test</th>
            <th>Typing Test</th>
            <th>Typing Test2</th>
            <th>Typing Test3</th>
            <th>Typing Test4</th>
            <th class="hidden-xs" >Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="candidate-list">
        @foreach ($data as $candidate)
        <tr id="candidate_id{{$candidate->id}}">
            <td>{{ $candidate->name_vacancy }}</td>
            <td>{{ $candidate->name}} {{ $candidate->last_name}}</td>
            <td>{{ $candidate->phone }}</td>
            <td>{{ $candidate->mail }}</td>
            <td>{{ $candidate->channel }}</td>
            <td>{{ $candidate->listening_test }}</td>
            <td>{{ $candidate->grammar_test }}</td>
            <td>{{ $candidate->typing_test }}</td>
            <td>{{ $candidate->typing_test2 }}</td>
            <td>{{ $candidate->typing_test3 }}</td>
            <td>{{ $candidate->typing_test4 }}</td>
            @switch($candidate->status)
                @case(1)
                    <td class="hidden-xs">
                        <span class='badge badge-success'>Activated</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="{{$candidate->id}}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-candidate" title="Deactivated" data-type="confirm" value="{{$candidate->id}}"><i class="fa fa-window-close"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary open-documents" onclick="openDocument('{{$candidate->id}}')" data-toggle="tooltip" title="Documents" value="{{$candidate->id}}"><i class="fa  fa-folder-open"></i></button>

                    </td>
                @break
                @case(2)
                <td class="hidden-xs">
                    <span class='badge badge-secondary'>Deactivated</span>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-success off-candidate" title="Activated" data-type="confirm" value="{{$candidate->id}}" ><i class="fa fa-check-square-o"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert delete-candidate" title="Delete" data-type="confirm" value="{{$candidate->id}}"><i class="fa fa-trash-o"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary open-documents" onclick="openDocument('{{$candidate->id}}')" data-toggle="tooltip" title="Documents" value="{{$candidate->id}}"><i class="fa  fa-folder-open"></i></button>
                </td>
                @break
            @endswitch
        </tr>
        @endforeach
    </tbody>
</table>
{!! $data->render() !!}