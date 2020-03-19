
<table class="table table-striped text-center " id="tag_container_incident"  >
    <thead class="text-white thead-yasc">
        <tr>
            <th width="100px">Operator</th>
            <th>Client</th>
            <th>Start</th>
            <th>End</th>
            <th>Total</th>
            <th>Note</th>
            <th>Reason</th>
            <th>Supervisor</th>
        </tr>
    </thead>
    <tbody id="incident-list">
    @foreach ($reports as $report)
        <tr id="report_id{{$report->id}}" >
            <td>{{$report->name}} {{$report->last_name}}</td>
            <td>{{$report->client_name}}</td>
            <td>{{$report->start}}</td>
            <td>{{$report->end}}</td>
            <td>{{$report->duration}}</td>
            <td>{{$report->note}}</td>
            <td>{{$report->setting_name}}</td>
            <td>{{$report->supervisor_name}} {{$report->supervisor_last_name}}</td>
               
        </tr>
        @endforeach
      
    </tbody>
</table>