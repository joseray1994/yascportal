<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            <th scope="col">Operator</th>
            <th scope="col" >Client</th>
            <th scope="col" >Day</th>
            <th scope="col" >Log in</th>
            <th scope="col" >Log out</th>
            <th scope="col" >Note</th>
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
            <td>@if($type->status == 2)
                    <span class="badge badge-pill badge-secondary">Day off</span>
                @elseif($type->status == 1)
                     <span class="badge badge-pill badge-success">Day on</span>
                @endif
            </td>
            @switch($type->type)
                    @case(1)
                    <td> <span class="badge badge-light">Workday</span></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary open_detail" data-toggle="tooltip" title="Audit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-info-circle"></i><input type="hidden" id="tokenSch{{$type->id}}" value="2"></button>
                        <button type="button" class="btn btn-sm btn-outline-warning text-dark open_detail" data-toggle="tooltip" title="Supended" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-level-up"></i><input type="hidden" id="tokenSch{{$type->id}}" value="1"></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger text-dark quitschedule" data-toggle="tooltip" title="Quit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-ban"></i></button>
                        
                    </td>
                    @break
                    @case(2)
                    <td> <span class="badge badge-training">Training</span></td>
                    <td>
                       <button type="button" class="btn btn-sm btn-outline-primary open_detail" data-toggle="tooltip" title="Audit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-info-circle"></i><input type="hidden" id="tokenSch{{$type->id}}" value="2"></button>
                        <button type="button" class="btn btn-sm btn-outline-warning text-dark open_detail" data-toggle="tooltip" title="Supended" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-level-up"></i><input type="hidden" id="tokenSch{{$type->id}}" value="1"></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                    </td>
                    @break
                    @case(3)
                    <td> <span class="badge badge-coaching">Coaching</span></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary open_detail" data-toggle="tooltip" title="Audit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-info-circle"></i><input type="hidden" id="tokenSch{{$type->id}}" value="2"></button>
                        <button type="button" class="btn btn-sm btn-outline-warning text-dark open_detail" data-toggle="tooltip" title="Supended" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-level-up"></i><input type="hidden" id="tokenSch{{$type->id}}" value="1"></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                    </td>
                    @break
                    @case(4)
                    <td><span class="badge badge-dark">Extra</span></td>
           
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary open_detail" data-toggle="tooltip" title="Audit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-info-circle"></i><input type="hidden" id="tokenSch{{$type->id}}" value="2"></button>
                        <button type="button" class="btn btn-sm btn-outline-warning text-dark open_detail" data-toggle="tooltip" title="Supended" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-level-up"></i><input type="hidden" id="tokenSch{{$type->id}}" value="1"></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deleteschedule" data-toggle="tooltip" title="Delete" data-type="confirm" value="{{$type->id}}"><i class="fa fa-trash-o"></i></button>
                    </td>
                    @break
                @endswitch
          
        </tr>
        @empty
            <tr id="table-row" class="text-center">
                <th colspan="9" class="text-center">
                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                </th>
            </tr>
        @endforelse
    </tbody>
</table>

{!! $data->render() !!}