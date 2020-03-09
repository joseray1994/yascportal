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
                            <h3>Clients</h3>
                        </div>
                        <br/>
                          <div class="form-check col-sm-12">
                            <select class="form-control js-example-basic-single" id="client">
                                    <option value="all">All Clients</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}" >{{$client->name}}</option>
                                    @endforeach
                                </select>
                          </div>
                    </div>
                  </div>
                  </br>
                  <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Operators</h3>
                        </div>
                        <br/>
                          <div class="form-check col-sm-12">
                            <select class="form-control js-example-basic-single" id="operator">
                                    <option value="all">All Operators</option>
                                    @foreach($operators as $operator)
                                        <option value="{{$operator->id}}" >{{$operator->name}} {{$operator->lname}}</option>
                                    @endforeach
                                </select>
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
                          <input type="time" class="form-control has-error" id="time_extra" name="time_extra" value="" maxlength ="15">
                        </div>
                        <div class="col-sm-6">
                          <label for="sel1">Duration:</label>
                          <input type="time" class="form-control has-error" id="duration" name="duration" value="" maxlength ="15">
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
            <input type="hidden" id="usertype_id" name="usertype_id" value="0"> 
            </div>
          </div>
        </div>