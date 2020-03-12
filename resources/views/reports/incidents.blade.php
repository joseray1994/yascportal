<div class="col-sm-12">
    <div class="row">
            <div class="form-group col-sm-4">
                                <label for="sel1">Select Client:</label>
                                <select class="form-control js-example-basic-single scheduleWeeklySearch" id="clientSearch">
                                    <option value="all">All Clients</option>
                                  
                                        <option value="" ></option>
                                    
                                </select>
            </div>
            <div class="form-group col-sm-4">
                                <label for="sel1">Select Operator:</label>
                                <select class="form-control js-example-basic-single scheduleWeeklySearch" id="operatorSearch">
                                    <option value="all">All Operators</option>
                                   
                                        <option value="" ></option>
                                    
                                </select>
            </div>
            <div class="form-group col-sm-4">
                                <label for="sel1">Select Date:</label>
                                <input type="date" value="" id="dateSearch" name="dateSearch" class="form-control scheduleWeeklySearch">
            </div>
    </div>                           
</div>
<table class="table table-striped text-center" id="tag_container"  >
    <thead class="text-white thead-yasc">
        <tr>
            <th width="100px">Date</th>
            <th>Operator</th>
            <th>Client</th>
            <th>Off</th>
            <th>On</th>
            <th>Total</th>
            <th>Reason</th>
            <th>Supervisor</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody id="incident-list">
      
    </tbody>
</table>