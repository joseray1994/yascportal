
<!-- MODAL SECTION -->
<div class="modal fade" id="myModalProv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
				<div class="modal-header text-white modaldelichef" >
                     <h4 class="modal-title" id="myModalLabel">Registro Inventory <i class="fa fa-user-plus"></i></h4>
				</div>
				
				<form enctype="multipart/form-data" method="POST" id="provForm" class="form-horizontal">
					<div class="modal-body">
                        <div class="form-group error">
							<div class="btn-group col-sm-12">
								<button class="btn modaldelichef" disabled><i class="fa fa-user"></i></button>
								<select class="js-example-basic-single form-control" name="id_provider2" id="id_provider2">
                                    @foreach($providers as $prov)
                                    <option value="{{$prov->id}}">{{$prov->name}}</option>
                                    @endforeach

                                </select>
							</div>
						</div>
                    </div>
                    
					<div class="modal-footer">
						<button type="button"  class="btn btn-secondary"  data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn modaldelichef" id="btn-save-prov" value="update">Guardar</button>
					</div>
				</form> 
			  <input type="hidden" id="inventory_id" name="inventory_id" value="0"> 
            </div>
        </div>
</div>