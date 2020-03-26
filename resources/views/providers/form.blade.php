 <!-- MODAL SECTION -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
				<div class="modal-header text-white modaldelichef" >
                     <h4 class="modal-title" id="myModalLabel">Registro Provider <i class="fa fa-user-plus"></i></h4>
				</div>
				
				<form enctype="multipart/form-data" method="POST" id="providerForm" class="form-horizontal">
					<div class="modal-body">
					
							<div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn modaldelichef" disabled><i class="fa fa-user-plus"></i></button>
									<input type="text" class="form-control has-error" id="name" name="name" placeholder="Enter new provider" value="" maxlength ="60">
								</div>
							</div>

							<div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn modaldelichef" disabled><i class="fa fa-id-card"></i></button>
									<input type="text" class="form-control has-error" id="rfc" name="rfc" placeholder="RFC" value="" maxlength ="60">
								</div>
							</div>

							<div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn modaldelichef" disabled><i class="fa fa-phone"></i></button>
									<input type="tel" class="form-control has-error" id="phone" name="phone" placeholder="Phone" value="">
								</div>
							</div>

							<div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn modaldelichef" disabled><i class="fa fa-envelope"></i></button>
									<input type="text" class="form-control has-error" id="email" name="email" placeholder="Email" value="">
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<button type="button"  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn modaldelichef" id="btn-save" value="add">Guardar</button>
					</div>
				</form> 
			  <input type="hidden" id="provider_id" name="provider_id" value="0"> 
            </div>
        </div>
</div>