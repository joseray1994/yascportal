
        <div class="modal fade" id="myModaSuspended" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header text-white  bg-danger" >
                            <h4 class="modal-title" >Suspended User <i class="fa fa-repeat"></i> <i class="fa fa-calendar"></i></h4>
				        </div>
              <form enctype="multipart/form-data" method="POST" id="SuspendedForm" class="form-horizontal">
                <div class="modal-body">       
                <div class="col-sm-12">
                    <div class="row">
                        <br/>
                        <div class="col-sm-6">
                          <label for="sel1">Date Start:</label>
                          <input type="date" class="form-control has-error" id="date_startS" name="time_start" value="" required>
                        </div>
                        <div class="col-sm-6">
                          <label for="sel1">Date End:</label>
                          <input type="date" class="form-control has-error" id="date_EndS" name="time_end" value="" required>
                      </div>
                      </br>
                    </div>
                  </div>
                  </br>
                </div>
                <div class="modal-footer">
                  <div class="col-sm-12 text-center">
                      <button type="button"  class="btn btn-danger cancel_data" data-dismiss="modal">Cancelar</button>
					  <button type="submit" class="btn btn-success" id="btn-saveS" value="update">Guardar</button>
                  </div>
                </div>
            </form> 
            <input type="hidden" id="shcedule_idS"  value="0">
            <input type="hidden" id="user_suspended"  value="0"> 
            </div>
          </div>
        </div>