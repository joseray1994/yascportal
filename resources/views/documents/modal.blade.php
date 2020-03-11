<div class="modal fade" id="modalDocuments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modaldelichef" >
            <h4 class="modal-title" id="myModalLabel">Documents <i class="fa fa-folder-open"></i></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-content" style="max-height:75vh; overflow: scroll;">
                <div class="container my-3">
                    <form id="formDocuments"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                    <div class="form-row">
                            <div class="card">
                                <div class="header">
                                    <h2>Upload user files <small>(pdf/png/jpg/docx/xlsx/zip)</small></h2>
                                </div>
                                <div class="body">
                                    <input type="file" name="document[]" class="dropify" multiple>
                                </div> 
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-success" id="btn-save-documents" value="add"><i class="fa  icon-cloud-upload"></i> Upload</button>
                                </div>
                            </div>
                    </div>
                
                        <input type="hidden" id="client_id_document" name="client_id_document">
                    </form>
                </div>
          
           
                <div class="col-sm-12 table-documents">
                    <div class="table-responsive">
                        <table class="table table-striped text-center" id="table-documents">
                            <thead class="text-white thead-yasc">
                                <tr>
                                    <th>Document</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody id = 'document-list'></tbody>
                            <tr id="no-data-doc" style="display:none"><td colspan="2">NO DATA</td></tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>