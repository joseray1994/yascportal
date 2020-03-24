    <!-- MODAL SECTION -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header text-white  bg-danger" >
                            <h4 class="modal-title" id="myModalLabelType">Create User Type <i class="fa fa-user-plus"></i></h4>
				</div>
              <form enctype="multipart/form-data" method="POST" id="typeUserForm" class="form-horizontal">
                <div class="modal-body">
							 <div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn modaldelichef" disabled><i class="fa fa-user-plus"></i></button>
									 <input type="text" class="form-control has-error" id="name" name="name" placeholder="Ingrese nuevo Perfil" value="" maxlength ="15">
								</div>
							</div>
                </div>
                <div class="modal-footer text-center">
                  <div class="col-sm-12">
                    <button type="button"  class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="btn-save" value="add">Save</button>
                  </div>
                </div>
			  </form> 
			  <input type="hidden" id="usertype_id" name="usertype_id" value="0"> 
            </div>
          </div>
        </div>