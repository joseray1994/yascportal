<table class="table table-striped text-center" id="tag_container_attendance">
    <thead class="text-white thead-yasc">
        <tr>
            <th colspan="2"></th>
            <th colspan="2" scope="colgroup">Sunday</th>
            <th colspan="2" scope="colgroup">Monday</th>
            <th colspan="2" scope="colgroup">Tuesday</th>
            <th colspan="2" scope="colgroup">Wednesday</th>
            <th colspan="2" scope="colgroup">Thursday</th>
            <th colspan="2" scope="colgroup">Friday</th>
            <th colspan="2" scope="colgroup">Saturday</th>
            <th colspan="2"></th>
        </tr>
    </thead> 

    <thead class="table-success"> 
        <tr>
            <th colspan="2">Operator</th>

            <th scope="col">Start</th>
            <th scope="col">End</th>

            <th scope="col">Start</th>
            <th scope="col">End</th>

            <th scope="col">Start</th>
            <th scope="col">End</th>

            <th scope="col">Start</th>
            <th scope="col">End</th>

            <th scope="col">Start</th>
            <th scope="col">End</th>

            <th scope="col">Start</th>
            <th scope="col">End</th>

            <th scope="col">Start</th>
            <th scope="col">End</th>

            <th colspan="2">Duration</th>
        </tr>
    </thead>
    <tbody>
        @foreach($time_clock as $key => $tc)
            <tr id="attendance_id{{$key}}::{{$tc->id}}">
            <td colspan="2">{{$tc->name}}</td>

            <td scope="col"></td>
            <td scope="col"></td>

            <td scope="col"></td>
            <td scope="col"></td>

            <td scope="col"></td>
            <td scope="col"></td>

            <td scope="col"></td>
            <td scope="col"></td>

            <td scope="col"></td>
            <td scope="col"></td>

            <td scope="col"></td>
            <td scope="col"></td>

            <td scope="col"></td>
            <td scope="col"></td>

            <td colspan="2"></td>
            </tr>
        @endforeach  
   </tbody>
</table>