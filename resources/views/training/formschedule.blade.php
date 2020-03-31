    <!-- MODAL SECTION -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header modaldelichef" >
            <div class="col-xl-12 col-xs-12 col-md-12 col-sm-12">
              <h6 class="modal-title" id="myModalLabel">Update Schedule</h6>
              <div class="row">
                <div class="col-xl-6 col-xs-6 col-md-6 col-sm-6" id="label_trainer">
                  <label for="entrenador">Trainer:</label>
                </div>
                <div class="col-xl-6 col-xs-6 col-md-6 col-sm-6" id="label_client" >
                  <label for="cliente">Client:</label>
                </div>
              </div>
            </div>
          </div>
          <form enctype="multipart/form-data"  id="trainingForm" class="form-horizontal">
            <div class="modal-body">
              <div class="col-xl-12 col-xs-12 col-md-12 col-sm-12">
                <div class="row">
                  <div class="col-xl-12 col-xs-12 col-md-12 col-sm-12 ">
                    <h5>Schedule</h5>
                    <div class="row">
                      <div class="col-xl-6 col-xs-12 col-md-6 col-sm-12 form-group">
                        <label for="sel1">Time Start:</label>
                        <input type="time" class="form-control has-error" id="time_start" name="time_start" value="" maxlength ="15">
                      </div>
                      <div class="col-xl-6 col-xs-12 col-md-6 col-sm-12 form-group">
                        <label for="sel1">Time End:</label>
                        <input type="time" class="form-control has-error" id="time_end" name="time_end" value="" maxlength ="15">
                      </div>
                    </div>
                  </div>
                  <br/>
                  <div class="col-xl-12 col-xs-12 col-md-12 col-sm-12 ">
                    <div class="row">
                      <div class="col-xl-6 col-xs-12 col-md-6 col-sm-12 form-group">
                        <br/>
                        <h6>End Training:</h6>
                        <input type="date" name="sch_end_training" id="sch_end_training" class="form-control" title="Este campo solo admite letras" maxlength="60">
                        <input type="hidden" id="hidden_endTraining" name="hidden_endTraining" value=""> 
                        <input type="hidden" id="flag" name="flag" value="0"> 
                      </div>
                      <div class="col-xl-6 col-xs-12 col-md-6 col-sm-12 form-group">
                        <br/>

                        <h6>End Coaching (Optional):</h6>
                        <input type="date" name="sch_end_coaching" id="sch_end_coaching" class="form-control">
                        <input type="hidden" id="hidden_endCoaching" name="hidden_endCoaching" value=""> 
                      </div>
                    </div>
                  </div>
                  <br/>
                  <div class="col-xl-12 col-xs-12 col-md-12 col-sm-12 ">
                    <div class="row">
                      <div class="col-xl-12 col-xs-12 col-md-12 col-sm-12 form-group">
                        <br/>
                        <label for="sel1">Select Day Off:</label>
                        <select class="form-control js-example-basic-single"  id="sch_days" style="heigth:100px" name="days[]" multiple="multiple">
                            @foreach($days as $days)
                                <option value="{{$days->id}}" >{{$days['Eng-name']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <br/>
                  <div class="col-xl-12 col-xs-12 col-md-12 col-sm-12 ">
                    <div class="row">
                      <br/>
                      <div class="col-xl-6 col-xs-12 col-md-6 col-sm-12 form-group">
                        <div class="form-check col-sm-12">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="now" value="now">Update the schedule for subsequent dates
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br/>
                </div>
              </div>
              <div class="modal-footer">
                <div class="col-sm-12 text-center">
                    <button type="button"  class="btn btn-danger cancel_data" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="btn-save" value="add">Guardar</button>
                </div>
              </div>
          </form> 
          <input type="hidden" id="id_schedule" name="id_schedule" value="0"> 
        </div>
      </div>
    </div>