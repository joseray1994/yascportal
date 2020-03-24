	<!-- MODAL SECTION -->
    <?php 
        $user = Auth::user();
    ?>
<div class="col-sm-12 formulario-zoom" style="display:none">
        <form id="formZoom" class="form-horizontal" enctype="multipart/form-data">
        {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4 form-group">
                    <h6>Zoom:</h6>
                    <input type="text" name="name" id="name" class="form-control" title="Este campo solo admite letras" maxlength="120">
                </div>
                <div class="col-sm-4 form-group">
                    <h6>Email:</h6>
                    <input name="email" id="email" class="form-control" title="Este campo solo admite letras" maxlength="60"></input>
                </div>
                <div class="col-sm-4 form-group">
                    <h6>Password:</h6>
                    <input name="password" id="password" class="form-control" title="Este campo solo admite letras" maxlength="60"></input>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 text-center">					 
        <button type="button" class="btn btn-danger btn-cancel">Cancel</button>
        <button type="submit" class="btn btn-success" id="btn-save" value="add">Save</button>
    </div>	
</form>
<input type="hidden" id="zoom_id" name="zoom_id">

</div>
