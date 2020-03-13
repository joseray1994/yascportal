<div class="col-sm-12">
    <div class="row">
            <div class="form-group col-sm-4">
                                <label for="sel1">Select Client:</label>
                                <select class="form-control js-example-basic-single scheduleWeeklySearch" id="clientSearch">
                                    <option value="allClients">All Clients</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}" >{{$client->name}}</option>
                                    @endforeach
                                </select>
            </div>
            <div class="form-group col-sm-4">
                                <label for="sel1">Select Operator:</label>
                                <select class="form-control js-example-basic-single scheduleWeeklySearch" id="operatorSearch">
                                    <option value="allOperators">All Operators</option>
                                    @foreach($operators as $operator)
                                        <option value="{{$operator->id}}" >{{$operator->name}} {{$operator->lname}}</option>
                                    @endforeach
                                </select>
            </div>
            <div class="form-group col-sm-2">
                                <label for="sel1">Select Operator:</label>
                                <select class="form-control js-example-basic-single scheduleWeeklySearch" id="worktypesearch">
                                    <option value="allWorks">All Work Type</option>
                                        <option value="1" >Workday</option>
                                        <option value="2" >Training</option>
                                        <option value="3" >Coaching</option>
                                        <option value="4" >Extra</option>
                                </select>
            </div>
            <div class="form-group col-sm-2">
                                <label for="sel1">Select Date:</label>
                                <input type="date" value="{{$today}}" id="dateSearch" name="dateSearch" class="form-control scheduleWeeklySearch">
            </div>
    </div>                           
</div>

                           