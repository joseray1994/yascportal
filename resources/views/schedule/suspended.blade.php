<div class="col-sm-12 text-center view-suspended" style="display:none;">
                        <div class="header">
                            <h1>Suspended <i class="fa fa-tasks"></i></h1>
                            <input type="hidden" id="auditid" value="">
                            <ul class="header-dropdown">
                                <li> 
                                    <div class="btn-group">
                                        <a href="javascript:void(0);" class="btn btn-success-create" disabled="" id="btn_add_suspended">New Suspended &nbsp;<i class="fa fa-plus" style="color:white"></i></a> 
                                        <button type="button" class="btn btn-danger back-weekly">Back to Weekly</button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                            <div class="row text-left">
                                <div class="form-group col-sm-2">
                                                <label for="sel1">Select Date:</label>
                                                <input type="date" value="" id="dateSearchaudit" name="dateSearch" class="form-control AuditSearch">
                                </div>
                                <div class="form-group col-sm-2">
                                                <label for="sel1">Select Time:</label>
                                                <input type="time" value="" id="timeSearchaudit" name="dateSearch" class="form-control AuditSearch">
                                </div>
                            </div>
                            <div class="table-responsive tabletwo">
                                <table class="table table-striped text-center">
                                    <thead class="text-white thead-yasc">
                                        <tr>
                                            <th>User</th>
                                            <th>Date Start</th>
                                            <th>Date End</th>
                                            <th>Status</th>
                                            <th>options</th>
                                        </tr>
                                    </thead>
                                    <tbody id="supended-table">
                                    
                                    </tbody>
                                </table> 
                            </div>
                        </div>

