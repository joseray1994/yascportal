 <!-- MODAL SECTION -->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
				<div class="modal-header text-white modaldelichef" >
                     <h4 class="modal-title" id="myModalLabel">Registro Supply <i class="fa fa-user-plus"></i></h4>
				</div>
				
				<form enctype="multipart/form-data" method="POST" id="supplyForm" class="form-horizontal">
					<div class="modal-body">
							
						<div class="col-md-6 mb-3">
                            <div class="input-group">
                                       
                                            <input type="hidden" id="id_department" name="id_department" value="2">
                                     
                            </div> 
                        </div>
                            
						<div class="col-md-6 mb-3">
                            <div class="input-group">
                                        @foreach ($providers as $prov)
                                            <input type="hidden" id="id_provider" name="id_provider" value="{{$prov['id']}}">
                                        @endforeach
                            </div> 
                        </div>

							<div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn modaldelichef" disabled><i class="fa fa-user-plus"></i></button>
									<input type="text" class="form-control has-error" id="name" name="name" placeholder="Enter new supply" value="" maxlength ="60">
								</div>
							</div>
						
							<div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn modaldelichef" disabled><i class="fa fa-phone"></i></button>
									<input type="number" class="form-control has-error" id="quantity" name="quantity" placeholder="Quantity" value="">
								</div>
							</div>

							<div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn modaldelichef" disabled><i class="fa fa-envelope"></i></button>
									<input type="number" class="form-control has-error" id="price" name="price" placeholder="Price" value="">
								</div>
                            </div>
                            
                            <div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn modaldelichef" disabled><i class="fa fa-envelope"></i></button>
									<input type="number" class="form-control has-error" id="cost" name="cost" placeholder="Cost" value="">
								</div>
                            </div>
                            
                            <div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn modaldelichef" disabled><i class="fa fa-envelope"></i></button>
									<input type="number" class="form-control has-error" id="total_price" name="total_price" placeholder="total_price" value="">
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<button type="button"  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn modaldelichef" id="btn-save" value="add">Guardar</button>
					</div>
				</form> 
			  <input type="hidden" id="supply_id" name="supply_id" value="0"> 
            </div>
        </div>
</div>