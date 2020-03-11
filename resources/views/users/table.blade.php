<table class="table table-striped text-center" id="tag_container">
    <thead class="text-center text-white thead-yasc">
        <tr>
            <th width="100px">ID</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Entrance Date</th>
            <th>Birthday</th>
            <th class="hidden-xs" >Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="user-list">
        @forelse ($data as $user)
        <tr id="user_id{{$user->id}}">
            <td>{{ $user->id }}</td>
            <td>{{ $user->User_info['name'] }}</td>
            <td>{{ $user->User_info['last_name'] }}</td>
            <td>{{ $user->email}}</td>
            <td>{{ $user->User_info['phone'] }}</td>
            <td>{{ $user->User_info['entrance_date'] }}</td>
            <td>{{ $user->User_info['birthdate'] }}</td>
            @switch($user->id_status)
                @case(1)
                    <td class="hidden-xs text-center">
                        <span class='badge badge-success'>Activated</span>
                    </td>
                    <td class="text-center">
                        @if($user->id != 1)
                        <button type="button" class="btn btn-sm btn-outline-secondary open-documents" title="Documents" data-toggle="tooltip" value="{{$user->id}}"><i class="fa  fa-folder-open"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="{{$user->id}}"  ><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert delete-op" data-toggle="tooltip" title="Desactivated" data-type="confirm" value="{{$user->id}}"><i class="fa fa-window-close"></i></button>
                        @endif
                    </td>
                @break
                @case(2)
                    <td class="hidden-xs">
                        <span class='badge badge-secondary'>Desactivated</span>
                    </td>
                    <td>
                         @if($user->id != 1)
                            <button type="button" class="btn btn-sm btn-outline-success delete-op" title="Activated" data-toggle="tooltip" data-type="confirm" value="{{$user->id}}" ><i class="fa fa-check-square-o"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert destroy-op" data-toggle="tooltip" title="Delete" data-type="confirm" value="{{$user->id}}"><i class="fa fa-trash-o"></i></button>
                        @endif
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