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
                                            <th>Event</th>
                                            <th>Date</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody id="audit-table">
                                    
                                    </tbody>
                                </table> 
                            </div>
                        </div>

<div class="modal fade" id="myModaAudit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header text-white  bg-danger" >
                            <h4 class="modal-title" >Detail Audit <i class="fa fa-repeat"></i> <i class="fa fa-calendar"></i></h4>
				        </div>
              <form enctype="multipart/form-data" method="POST" id="SuspendedForm" class="form-horizontal">
                <div class="modal-body">       
                <div class="col-sm-12">
                    <div class="row">
                        <br/>
                        <div class="col-sm-6">
                            <ul class="list-group">
                                <li class="list-group-item active">New Values</li>
                                <li id="select-option-news" class="list-group-item" style="display:none">Option:  <select class="form-control" id="option-news" disabled>
                                    @foreach($settings as $set)
                                        <option value="{{$set->id}}" >{{$set->name}}</option>
                                    @endforeach
                                </select></li>
                            </ul>
                            <ul id="new_values" class="list-group">
                                
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-group">
                                <li class="list-group-item active" >Old Values</li>
                                <li id="select-option-old" class="list-group-item" style="display:none">Option:  <select class="form-control" id="option-old" disabled>
                                    @foreach($settings as $set)
                                        <option value="{{$set->id}}" >{{$set->name}}</option>
                                    @endforeach
                                </select></li>
                            </ul>
                            <ul id="old_values" class="list-group">
                        
                            </ul>
                      </div>
                      </br>
                    </div>
                  </div>
                  </br>
                </div>
                <div class="modal-footer">
                  <div class="col-sm-12 text-center">
                      <button type="button"  class="btn btn-danger cancel_data_detail" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
            </form> 
            <input type="hidden" id="shcedule_idS"  value="0">
            <input type="hidden" id="user_suspended"  value="0"> 
            </div>
          </div>
        </div>