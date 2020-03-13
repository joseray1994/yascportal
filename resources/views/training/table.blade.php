<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            {{-- <th width="100px">ID</th> --}}
            <th>Client</th>
            <th>Trainee</th>
            <th>Trainer</th>
            <th>Schedule</th>
            <th>At Woork</th>
            <th class="hidden-xs" >Zoom Meting</th>
            <th class="hidden-xs" >Activities</th>
            <th >Ends Training</th>
            {{-- <th>Option</th> --}}
        </tr>
    </thead>
    <tbody id="trainings-list">
        @foreach ($data as $training)
        <tr id="trainings_id{{$training->id}}">
            <td style ="background:{{$training->color}}" >{{ $training->client }}</td>
           <td>{{ $training->name }} {{ $training->lastname }}</td>
           <td>{{ $training->name_trainer }} {{ $training->lastname_trainer }}</td>
           <td>{{ $training->time_s}} - {{ $training->time_e}}</td>
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
        </tr>
        @endforeach
    </tbody>
</table>
{{-- {!! $data->render() !!} --}}