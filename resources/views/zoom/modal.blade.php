    <!-- MODAL SECTION -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header text-white modaldelichef" >
                            <h4 class="modal-title" id="myModalLabel">Assign Zoom<i class="fa fa-video-camera"></i></h4>
				</div>
              <form enctype="multipart/form-data" method="POST" id="assignForm" class="form-horizontal">
                <div class="modal-body">
							 <div class="form-group error">
								<div class="btn-group col-sm-12">
									<button class="btn" disabled><i class="fa fa-user"></i></button>
                                    <select name="id_user" id = "id_user" class="custom-select">
                                             <option >Select a Trainer</option>
                                            @foreach($users as $user)
                                            <option value = "{{$user->id}}">{{$user->name}} {{$user->last_name}}</option>
                                            @endforeach
                                    </select>
								</div>
							</div>
                </div>
                <div class="modal-footer">
				  <button type="button"  class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success" id="btn-save-user" value="add">Save</button>
                </div>
			  </form> 
			  <input type="hidden" id="zoom_user_id" name="zoom_user_id"> 
            </div>
          </div>
        </div>