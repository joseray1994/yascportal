<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            {{-- <th width="100px">ID</th> --}}
            <th>Client</th>
            <th>Trainee</th>
            <th>Trainer</th>
            <th>Schedule</th>
            <th>At Work</th>
            <th>Work Type</th>
            <th class="hidden-xs" >Zoom Meting</th>
            <th class="hidden-xs" >Activities</th>
            <th >Ends Training</th>
            <th class="hidden-xs" >Status</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody id="trainings-list">
        @forelse ($data as $training)
        <tr id="trainings_id{{$training->id_user}}" class="rowTraining">
            <td style ="background:{{$training->color}}" >{{ $training->client }}</td>
            <td>{{ $training->name }} {{ $training->lastname }}</td>
            <td>{{ $training->name_trainer }} {{ $training->lastname_trainer }}</td>
            <td style ="background:{{$training->color}}">{{ $training->time_s}} - {{ $training->time_e}}</td>
            <td>{{$training->setting}}</td>
            @switch($training->type)
                    @case(2)
                    <td> <span class="badge badge-training">Training</span></td>
                    @break
                    @case(3)
                    <td> <span class="badge badge-coaching">Coaching</span></td>
                    @break
                @endswitch
            <td class="hidden-xs" >Zoom</td>
            <td class="hidden-xs" >Activities</td>
            <td>{{ $training->end_training}}</td>
            @switch($training->status_user)
                @case(1)
                    <td class="hidden-xs">
                        <span class='badge badge-success'>Activated</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-editInfo" title="Edit User Information" value="{{$training->id_user}}"  ><i class="icon-user-following"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-editSchedule" title="Edit Schedule" id="btn-edit" value="{{$training->id_schedule}}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-type" title="Disable User and Schedule" data-type="confirm" value="{{$training->id_user}}"><i class="fa fa-window-close"></i></button>
                    </td>
                @break
                @case(2)
                <td class="hidden-xs">
                    <span class='badge badge-secondary'>Deactivated</span>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-success off-type" title="Activated" data-type="confirm" value="{{$training->id_user}}" ><i class="fa fa-check-square-o"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deleteTraining" title="Delete User" data-type="confirm" value="{{$training->id_user}}"><i class="fa fa-trash-o"></i></button>
                </td>
                @break
            @endswitch
        </tr>
        @empty
            <tr id="table-row" class="text-center">
                <th colspan="11" class="text-center">
                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                </th>
            </tr>
        @endforelse
    </tbody>
</table>
{{-- {!! $data->render() !!} --}}