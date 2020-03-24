	<!-- MODAL SECTION -->
    <?php 
        $user = Auth::user();
    ?>
<div class="col-sm-12 formulario" style="display:none">
    <form id="formNews" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
        {{ csrf_field() }}
        <hr>
        <div class="row">
            <div class="col-sm-6 form-group">
                <h6>Title:</h6>
                <input type="text" name="title" id="title" class="form-control" maxlength="150">
            </div>
            <div class="col-sm-3 form-group">
                <h6>Who can see this?:</h6>
                <select class="selectpicker selectpick form-control" id='id_type_user' multiple data-live-search="true" name='id_type_user[]'>
                    @foreach ($types as $type)
                        <option value='{{$type->id}}'>{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3 form-group">
                <h6>Allow Comments:</h6>
                <select class="form-control" id='status' name='status'>
                    <option value="1">With comments</option>
                    <option value="2">Without Comments</option>
                </select>
            </div>
            <div class="col-sm-12">
                <h6>Image:</h6>
                <input type="file" class="dropify dropify-event" id="news_picture" name="news_picture" data-default-file="" data-show-remove="true">
            </div>
            <div class="col-sm-12 form-group">
                <h6>Description:</h6>
                <textarea id="ckeditor"></textarea>
            </div>            
        </div>
        <hr>
        <div class="col-sm-12 text-center " >					 
            <button type="button" class="btn btn-danger btn-cancel">Cancel</button>
            <button type="submit" class="btn btn-success" id="btn-save" value="add">Save</button>
            <input type="hidden" id="id_hidden" name="id_hidden" value="0">
            <input type="hidden" id="flag_hidden" name="flag_hidden" value="false">
        </div>	
    </form>
</div>