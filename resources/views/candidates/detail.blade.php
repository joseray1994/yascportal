<!-- MODAL SECTION -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
				<div class="modal-header text-white modaldelichef" >
                     <h4 class="modal-title" id="myModalLabel">Registro Candidate<i class="fa fa-user-plus"></i></h4>
				</div>
	
					<div class="modal-body">

						<div class="form-row">
							<div class="col-md-6 mb-3">
								<label>Listening Test</label>
								<div class="input-group">
									<select class="custom-select" name="listening_test" id = "listening_test" >
											<option value = "">Select</option> 
											<option value = "A1">A1</option>
											<option value = "A2">A2</option> 
											<option value = "A3">A3</option> 
									</select>  
								</div> 
							</div>
							<div class="col-md-6 mb-3">
								<label>Grammar Test</label>
								<div class="input-group">
									<select class="custom-select" name="grammar_test" id = "grammar_test" >
											<option value = "">Select</option> 
											<option value = "A1">A1</option>
											<option value = "A2">A2</option> 
											<option value = "A3">A3</option> 
									</select>
								</div>
							</div>
						</div>

						
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label>Typing Test</label>
								<div class="input-group">
									<input type="number" min="0" max="100" class="form-control has-error" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" id="typing_test" name="typing_test" placeholder="" value="" >
								</div> 
							</div>

							<div class="col-md-3 mb-3">
							<label>&nbsp</label>
								<div class="input-group">
									<input type="number" min="0" max="100" class="form-control has-error"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" id="typing_test2" name="typing_test2" placeholder="" value="" >
								</div> 
							</div>

							<div class="col-md-3 mb-3">
							<label>&nbsp</label>
								<div class="input-group">
									<input type="number" min="0" max="100" class="form-control has-error"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" id="typing_test3" name="typing_test3" placeholder="" value="" >
								</div> 
							</div>

							<div class="col-md-3 mb-3">
							<label>&nbsp</label>
								<div class="input-group">
									<input type="number" min="0" max="100" class="form-control has-error"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" id="typing_test4" name="typing_test4" placeholder="" value="" >
								</div> 
							</div>
							
                   		</div>

					</div>

					<div class="modal-footer">
						<button type="button"  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					</div>
				
			 
            </div>
        </div>
    </div>