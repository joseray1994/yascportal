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
            <th>Option</th>
        </tr>
    </thead>
    <tbody id="trainings-list">
        {{-- @foreach ($data as $training) --}}
        @forelse ($data as $training)
        <tr id="trainings_id{{$training->id}}" class="rowTraining">
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
            <td>Zoom</td>
            <td>Activities</td>
            <td>{{ $training->end_training}}</td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-secondary open_change" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$training->id}}"  ><i class="fa fa-exchange"></i></button>
                <button type="button" class="btn btn-sm btn-outline-secondary open_modal" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$training->id}}"  ><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deleteschedule" data-toggle="tooltip" title="Delete" data-type="confirm" value="{{$training->id}}"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        {{-- @endforeach --}}
        @empty
            <tr id="table-row" class="text-center">
                <th colspan="8" class="text-center">
                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                </th>
            </tr>
        @endforelse
    </tbody>
</table>
{{-- {!! $data->render() !!} --}}