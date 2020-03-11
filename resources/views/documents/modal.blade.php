<div class="modal fade" id="modalDocuments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modaldelichef" >
            <h4 class="modal-title" id="myModalLabel">Documents <i class="fa fa-folder-open"></i></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-content">
                <div class="container my-3">
                    <form id="formDocuments"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                    <div class="form-row">
                            <div class="col-sm-10 form-group">
                                <h6>Document:</h6>
                                <input type="file" name="document[]" id="doc" multiple>
                            </div>
                            <div class="col-sm-2 form-group">
                            <br>
                                <button type="submit" class="btn btn-success" id="btn-save-documents" value="add">Save</button>
                            </div>
                    </div>
                
                        <input type="hidden" id="client_id_document" name="client_id_document">
                    </form>
                </div>
          
           
                <div class="col-sm-12 table-documents">
                    <div class="table-responsive" style="max-height:50vh; overflow: scroll;">
                        <table class="table table-striped text-center" id="tag_container">
                            <thead class="text-white thead-yasc">
                                <tr>
                                    <th>Document</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody id = 'document-list'></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>