<div class="col-sm-12 view-search-incident">
        <div class="row">
                <div class="form-group col-sm-3">
                                   
                                    <select class="form-control js-example-basic-single incident_reportSearch" id="clientSearch">
                                        <option value="AllClients">All Clients</option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}" >{{$client->name}}</option>
                                       @endforeach
                                   </select>
                </div>
                <div class="form-group col-sm-3">
                                   
                                    <select class="form-control js-example-basic-single incident_reportSearch" id="operatorSearch">
                                        <option value="AllOperators">All Operators</option>
                                        @foreach($operators as $op)
                                            <option value="{{$op->id_user}}" >{{$op->name}} {{$op->last_name}}</option>
                                        @endforeach
                                    </select>
                </div>
                <div class="form-group col-sm-3">
                                 
                                    <input type="date" id="startSearch" name="startSearch" class="form-control incident_reportSearch">
                </div>

                <div class="form-group col-sm-3">
                                 
                                 <input type="date" id="endSearch" name="endSearch" class="form-control incident_reportSearch">
             </div>
                
        </div>       
</div>
