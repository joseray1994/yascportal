<div class="col-sm-12">
    <div class="row">
            <div class="form-group col-sm-3">
                                <label for="sel1">Select Client:</label>
                                <select class="form-control js-example-basic-single trainingSearch" id="clientSearch">
                                    <option value="allClients">All Clients</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}" >{{$client->name}}</option>
                                    @endforeach
                                </select>
            </div>
            <div class="form-group col-sm-3">
                                <label for="sel1">Select Trainer:</label>
                                <select class="form-control js-example-basic-single trainingSearch" id="trainerSearch">
                                    <option value="allTrainers">All Operators</option>
                                    @foreach($trainers as $trainer)
                                    <option value="{{$trainer->id}}">{{$trainer->User_info->name}} {{$trainer->User_info->last_name}}</option>
                                    @endforeach
                                </select>
            </div>
            <div class="form-group col-sm-3">
                                <label for="sel1">Select Operator:</label>
                                <select class="form-control js-example-basic-single trainingSearch" id="operatorSearch">
                                    <option value="allOperators">All Operators</option>
                                    @foreach($operators as $operator)
                                        <option value="{{$operator->id}}" >{{$operator->name}} {{$operator->lname}}</option>
                                    @endforeach
                                </select>
            </div>
            
            <div class="form-group col-sm-3">
                                <label for="sel1">Work Type:</label>
                                <select class="form-control js-example-basic-single trainingSearch" id="worktypesearch">
                                    <option value="allWorks">All Work Type</option>
                                        <option value="2" >Training</option>
                                        <option value="3" >Coaching</option>
                                </select>
            </div>
    </div>                           
</div>

                           