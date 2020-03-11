$(document).ready(function(){
    var baseUrl = $("#baseUrl").val();

    //Create documents
    $("#formDocuments").on('submit',function (e) {
        console.log('button');
      
        e.preventDefault(); 
        // $('#btn-save-documents').attr('disabled', true);
        
        var formData = new FormData(this);
        var state = $('#btn-save-documents').val();
        var id = $('#client_id_document').val();
        var mat = $("#mat").val();
        var type = "POST"; //for creating new resource
        var my_url = baseUrl + '/document/' + id + '/' + mat;
        var file = "file";
        
        actions.edit_create(type,my_url,state,formData, file);
    });

    //Delete Document
    $(document).on('click','.deleteDocument',function(){
         
        var document_id = $(this).val();
        var my_url = baseUrl + '/documents/delete/' + document_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Are you sure you wish to delete this document?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                actions.deactivated(my_url);
                $('#modalDocuments').modal('hide');
            }else {
            swal("Cancelled", "Deletion Canceled", "error");
            }
        });
    });
});


const documents ={
    button: function(dato){
           var buttons='';
            if(dato.status== 1){
              
               buttons += ' <button type="button" class="btn btn-sm btn-outline-secondary download" data-toggle="tooltip" title="Download" value="'+dato.id+'"> <i class="fa fa-download"></i></li></button>';
               buttons += ' <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deleteDocument" data-toggle="tooltip" title="Delete" data-type="confirm" value="'+dato.id+'"> <i class="fa fa-trash-o"></i> </button>';
          
           }
           return buttons;
    },

}

function openDocument(id){
    var baseUrl = $("#baseUrl").val();

    $('#modalDocuments').modal('show');
    $('#formDocuments').trigger('reset');
    var mat = $("#mat").val();
    $('#client_id_document').val(id);
    var my_url = baseUrl + '/document/show/' + id + '/' + mat;
    actions.show(my_url)

}