<table class="table table-striped text-center" id="tag_container" style="max-height: 70vh;">
    <thead class="text-white thead-yasc">
        <tr>
            <th>Operator</th>
            <th>Client</th>
            <th>Log in</th>
            <th>Log out</th>
            <th>At Work </th>
            <th>Work Type</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="shcedule-list" class="table-data" >
        @forelse($data as $type)
        <tr id="shcedule_id{{$type->id}}">
            <td> @switch($type->setting)
                    @case('Start')
                    <i class="text-success fa fa-phone"></i> 
                    @break
                    @case('Late')
                    <i class="text-warning fa fa-phone"></i> 
                    @break
                @endswitch
            {{ $type->name }} {{ $type->lastname }}</td>
            <td style ="background:{{$type->color}}" >{{ $type->client }}</td>
            <td>{{ $type->time_s }}</td>
            <td>{{ $type->time_e }}</td>
            <td>    
                {{ $type->setting }}
            </td>
            @switch($type->type)
                    @case(1)
                        <td> <span class="badge badge-light">Workday</span></td>
                        @switch($type->status)
                            @case(1)
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger text-dark quitschedule" data-toggle="tooltip" title="Quit"  value="{{$type->id}}"  ><i class="fa fa-ban"></i></button>
                                    
                                </td>
                            @break
                            @case(2)
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger text-dark quitschedule" data-toggle="tooltip" title="Quit"  value="{{$type->id}}"  ><i class="fa fa-ban"></i></button>
                                    
                                </td>
                            @break
                            @case(3)
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary open_detail" data-toggle="tooltip" title="Audit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-info-circle"></i><input type="hidden" id="tokenSch{{$type->id}}" value="2"></button>
                                </td>
                            @break
                        @endswitch
                   
                    @break
                    @case(2)
                    <td> <span class="badge badge-training">Training</span></td>
                    <td>
                      
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                    </td>
                    @break
                    @case(3)
                    <td> <span class="badge badge-coaching">Coaching</span></td>
                    <td>
                       
                        <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                    </td>
                    @break
                    @case(4)
                    <td><span class="badge badge-dark">Extra</span></td>
                    @switch($type->status)
                            @case(1)
                                 <td>
                                    <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deleteschedule" data-toggle="tooltip" title="Delete" data-type="confirm" value="{{$type->id}}"><i class="fa fa-trash-o"></i></button>
                                </td>
                            @break
                            @case(2)
                                 <td>
                                    <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deleteschedule" data-toggle="tooltip" title="Delete" data-type="confirm" value="{{$type->id}}"><i class="fa fa-trash-o"></i></button>
                                </td>
                            @break
                            @case(3)
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary open_detail" data-toggle="tooltip" title="Audit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-info-circle"></i><input type="hidden" id="tokenSch{{$type->id}}" value="2"></button>
                                </td>
                            @break
                        @endswitch
                @break
            @endswitch
 
        </tr>
        @empty
            <tr id="table-row" class="text-center">
                <th colspan="8" class="text-center no-data">
                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                </th>
            </tr>
        @endforelse
    </tbody>
</table>
