    <!-- MODAL SECTION -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header text-white  bg-danger" >
                            <h4 class="modal-title" id="myModalLabel">Registro Perfil <i class="fa fa-user-plus"></i></h4>
				        </div>
              <form enctype="multipart/form-data" method="POST" id="typeUserForm" class="form-horizontal">
                <div class="modal-body">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-sm-12">
                          <h3>Schedule</h3>
                        </div> 
                        <br/>
                        <div class="col-sm-6">
                          <label for="sel1">Time Start:</label>
                          <input type="time" class="form-control has-error" id="time_start" name="time_start" value="" maxlength ="15">
                        </div>
                        <div class="col-sm-6">
                          <label for="sel1">Time End:</label>
                          <input type="time" class="form-control has-error" id="time_end" name="time_end" value="" maxlength ="15">
                      </div>
                    </div>
                  </div>
                  </br>
                  <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Day Off</h3>
                        </div>
                        <br/>
                        <div class="col-sm-12">
                        <label for="sel1">Select Day Off:</label>
                                <select class="form-control js-example-basic-single"  id="days" style="heigth:100px" name="days[]" multiple="multiple">
                                    @foreach($days as $days)
                                        <option value="{{$days->id}}" >{{$days['Eng-name']}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                  </div>
                  </br>
                  <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Options</h3>
                        </div>
                        <br/>
                          <div class="form-check col-sm-12">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" id="now" value="now">Update the schedule for subsequent dates
                            </label>
                          </div>
                          <div class="form-check col-sm-12">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" id="today" value="ev">Update the schedule for subsequent Sundays.
                            </label>
                          </div>
                    </div>
                  </div>
                  </br>
                  <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Extra Hour</h3>
                        </div>
                        <br/>
                        <div class="col-sm-6">
                          <label for="sel1">Time Start:</label>
                          <input type="time" class="form-control has-error timeinputsdata" id="time_startEx" name="time_start" value="" maxlength ="15">
                        </div>
                        <div class="col-sm-6">
                          <label for="sel1">Time End:</label>
                          <input type="time" class="form-control has-error" id="time_endEx" name="time_end" value="" maxlength ="15" disabled>
                      </div>
                      </br>
                      <div class="col-sm-12 text-center">
                          <label for="sel1">Duration (HH:mm):</label>

                          <div class="btn-group col-sm-12">
                          <input type="number" class="form-control has-error col-sm-4 timeinputsdata" id="hoursEx" pattern="[0-9]{2}" max="24" min="0" name="durationH" value="0"  requiered>:
                          <input type="number" class="form-control has-error col-sm-4 timeinputsdata" id="minutesEx" pattern="[0-9]{2}" max="59" min="0" name="durationM" value="0" requiered>
                          </div>
                      </div>
                    </div>
                  </div>
                  </br>
                </div>
                <div class="modal-footer">
                  <div class="col-sm-12 text-center">
                      <button type="button"  class="btn btn-danger cancel_data" data-dismiss="modal">Cancelar</button>
					            <button type="submit" class="btn btn-success" id="btn-save" value="add">Guardar</button>
                  </div>
                </div>
            </form> 
            <input type="hidden" id="shcedule_id" name="shcedule_id" value="0"> 
            </div>
          </div>
        </div>

            <!-- MODAL SECTION -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header text-white  bg-danger" >
                            <h4 class="modal-title" id="myModalLabel">Registro Perfil <i class="fa fa-user-plus"></i></h4>
				        </div>
              <form enctype="multipart/form-data" method="POST" id="ExtraForm" class="form-horizontal">
                <div class="modal-body">       
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Extra Hour</h3>
                        </div>
                        <br/>
                        <div class="col-sm-6">
                          <label for="sel1">Time Start:</label>
                          <input type="time" class="form-control has-error timeinputsdataExtra" id="time_startE" name="time_start" value="" maxlength ="15">
                        </div>
                        <div class="col-sm-6">
                          <label for="sel1">Time End:</label>
                          <input type="time" class="form-control has-error" id="time_endE" name="time_end" value="" maxlength ="15" disabled>
                      </div>
                      </br>
                      <div class="col-sm-12 text-center">
                          <label for="sel1">Duration (HH:mm):</label>

                          <div class="btn-group col-sm-12">
                          <input type="number" class="form-control has-error col-sm-4 timeinputsdataExtra" id="hours" pattern="[0-9]{2}" max="24" min="0" name="durationH" value="0"  requiered>:
                          <input type="number" class="form-control has-error col-sm-4 timeinputsdataExtra" id="minutes" pattern="[0-9]{2}" max="59" min="0" name="durationM" value="0" requiered>
                          </div>
                      </div>
                    </div>
                  </div>
                  </br>
                </div>
                <div class="modal-footer">
                  <div class="col-sm-12 text-center">
                      <button type="button"  class="btn btn-danger cancel_data" data-dismiss="modal">Cancelar</button>
					            <button type="submit" class="btn btn-success" id="btn-saveE" value="add">Guardar</button>
                  </div>
                </div>
            </form> 
            <input type="hidden" id="shcedule_idE" name="shcedule_idE" value="0"> 
            </div>
          </div>
        </div>