<div class="col-sm-12 text-center view-audit" style="display:none;">
                        <div class="header">
                            <h1>Audit <i class="fa fa-tasks"></i></h1>
                            <input type="hidden" id="auditid" value="">
                            <ul class="header-dropdown">
                                <li> <button type="button" class="btn btn-danger back-weekly">Back to Weekly</button></li>
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
                                            <th>Old Values</th>
                                            <th>New Values</th>
                                            <th>Event</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="audit-table">
                                    
                                    </tbody>
                                </table> 
                            </div>
                        </div>

