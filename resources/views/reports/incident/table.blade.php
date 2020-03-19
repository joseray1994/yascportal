<table class="table table-striped text-center" id="tag_container_incident">
    <thead class="text-white thead-yasc">
        <tr>
            <th scope="col">Operator</th>
            <th scope="col" >Client</th>
            <th scope="col" >On</th>
            <th scope="col" >Off</th>
            <th scope="col" >Total</th>
            <th scope="col" >Reason</th>
            <th scope="col" >Supervisor</th>
            <th scope="col" >Note</th>
        </tr>
    </thead>
    <tbody id="shcedule-list" class="table-data" >
        @forelse($reports as $report)
        <tr id="report_id{{$report->id}}">
            <td scope="row" >{{ $report->name }} {{ $report->last_name }}</td>
            <td scope ="row">{{ $report->client_name }}</td>
            <td scope ="row">{{ $report->start }}</td>
            <td scope ="row">{{ $report->end }}</td>
            <td scope ="row">{{ $report->duration }}</td>
            <td scope ="row">{{ $report->setting_name }}</td>
            <td scope ="row">{{ $report->supervisor_name }} {{ $report->supervisor_last_name }}</td>
            <td scope ="row">{{ $report->note }}</td>
          
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

{!! $reports->render() !!}