<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            <th scope="col">Operator</th>
            <th scope="col" >Client</th>
            <th scope="col" >Day</th>
            <th scope="col" >Log in</th>
            <th scope="col" >Log out</th>
            <th scope="col" >Work Type</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="shcedule-list" class="table-data" >
        @forelse($data as $type)
        <tr id="shcedule_id{{$type->id}}">
            <td scope="row" >{{ $type->name }} {{ $type->lastname }}</td>
            <td style ="background:{{$type->color}}" >{{ $type->client }}</td>
            <td>{{ $type->day }}</td>
            <td>{{ $type->time_s }}</td>
            <td>{{ $type->time_e }}</td>
            @switch($type->type)
                    @case(1)
                    <td> <span class="badge badge-light">Workday</span></td>
                    <td>
                        <a class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Assignament Type" id="btn-edit" href="/assignmenttype/{{$type->id}}"  ><i class="fa fa-info-circle"></i></a>
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                    </td>
                    @break
                    @case(2)
                    <td> <span class="badge badge-training">Training</span></td>
                    <td>
                        <a class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Assignament Type" id="btn-edit" href="/assignmenttype/{{$type->id}}"  ><i class="fa fa-info-circle"></i></a>
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                    </td>
                    @break
                    @case(3)
                    <td> <span class="badge badge-coaching">Coaching</span></td>
                    <td>
                        <a class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Assignament Type" id="btn-edit" href="/assignmenttype/{{$type->id}}"  ><i class="fa fa-info-circle"></i></a>
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                    </td>
                    @break
                    @case(4)
                    <td><span class="badge badge-dark">Extra</span></td>
           
                    <td>
                        <a class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Assignament Type" id="btn-edit" href="/assignmenttype/{{$type->id}}"  ><i class="fa fa-info-circle"></i></a>
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deleteschedule" data-toggle="tooltip" title="Delete" data-type="confirm" value="{{$type->id}}"><i class="fa fa-trash-o"></i></button>
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