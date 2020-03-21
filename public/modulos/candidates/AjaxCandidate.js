
$(document).ready(function(){
     
    clearload();
   
    var vac0 = $('#id_vacancy').val();

    var nameDeli='<a href="/vacancies">Vacancies</i></a> / <a href="/candidates/'+vac0+'">Candidates</i></a>';

    $('.nameDeli').html(nameDeli);
    $('#sidebar10').addClass('active');  

  //get base URL *********************
  var url = $('#url').val();

  
  $(window).on('hashchange', function() {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        }else{
            getData(page);
        }
    }
});


  //display modal form for creating new product *********************
  $('#btn_add').click(function(){
      $('#btn-save').val("add");
      $('#candidateForm').trigger("reset");
      $('#myModal').modal('show');
  });

    $('.btn-cancel').click(function(){
        $('#btn-save').val("add");
        $('#candidateForm').trigger("reset");
        $('#myModal').modal('hide');
    
    });

  
    $(document).on('click','.info_modal',function(){
        var  candidate_id = $(this).val();
        var my_url=url + '/detail/' +  candidate_id;
         actions.show(my_url);
     });

        //display modal form for product EDIT ***************************
        $(document).on('click','.open_modal',function(){
            $('#candidateForm').trigger("reset");
            var candidate_id = $(this).val();
            var my_url = url + '/' + candidate_id;
    
                actions.show(my_url);
           
        });
    
    
         //create new product / update existing product ***************************
         $("#candidateForm").on('submit',function (e) {
            console.log('button');
          
            e.preventDefault(); 
            var formData =  $("#candidateForm").serialize();
        
    
            //used to determine the http verb to use [add=POST], [update=PUT]
            var state = $('#btn-save').val();
            var type = "POST"; //for creating new resource
            var candidate_id = $('#candidate_id').val();;
            var my_url = url;
            if (state == "update"){
                type = "POST"; //for updating existing resource
                my_url += '/' + candidate_id;
            }
            
                console.log(formData);
            
                actions.edit_create(type,my_url,state,formData);
        
        });
    
    
        $(document).on('click','.off-candidate',function(){
            var id = $(this).val();
            var my_url =url + '/' + id;
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
                if($(this).attr('class') == 'btn btn-sm btn-outline-success off-candidate')
                {
                    title= "Do you want to activate this Candidate?";
                    text="The Candidate will be activated";
                    confirmButtonText="Activate";
    
                    datatitle="Activated";
                    datatext="Activated";
                    datatext2="Activation";
                }
                else 
                {
                    title= "Do you want to disable this Candidate?";
                    text= "The Candidate will be deactivated";
                    confirmButtonText="Deactivate";
    
                    datatitle="Deactivate";
                    datatext="Deactivate";
                    datatext2="Deactivation";
    
                }
    
    
                swal({
                    title: title,
                    text: text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn btn-danger",
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                    swal(datatitle, "Candidate "+datatext, "success");
                    actions.deactivated(my_url);
                    } 
                    else {
                    
                    swal("Cancelled", datatext2+" Cancelled", "error");
                
                    }
            });
        });
    
    
    
        
         //delete product and remove it from TABLE list ***************************
         $(document).on('click','.delete-candidate',function(){
            var candidate_id = $(this).val();
            var my_url = url + '/delete/' + candidate_id;
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            swal({
                title: "Do you want to delete this Candidate?",
                text: "The candidate will be permanently eliminated",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-danger",
                confirmButtonText: "Remove",
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: false
              },
              function(isConfirm) {
                if (isConfirm) {
                    actions.deactivated(my_url);
                }else {
                   swal("Cancelled", "Deletion canceled", "error");
                }
              });
            });

    
});






const candidates ={
    button: function(dato){
           var buttons='<div class="">';
            if(dato.status== 1){

                buttons += '  <button type="button"  data-toggle="tooltip" class="btn btn-sm btn-outline-primary  info_modal" title="Information" id="btn-info" value="'+dato.id+'"  ><i class="fa fa-info-circle"></i></button>'
                buttons += ' <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="'+dato.id+'"  ><i class="fa fa-edit"></i></button>';
                buttons += ' <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert off-candidate" title="Deactivated" data-type="confirm" value="'+dato.id+'"><i class="fa fa-window-close"></i></button>';
                buttons += '  <button type="button" class="btn btn-sm btn-outline-secondary open-documents" onclick="openDocument('+dato.id+')" data-toggle="tooltip" title="Documents" value="'+dato.id+'"><i class="fa  fa-folder-open"></i></button>';

          
           }else if(dato.status == 2){
               buttons += '  <button type="button"  data-toggle="tooltip" class="btn btn-sm btn-outline-primary  info_modal" title="Information" id="btn-info" value="'+dato.id+'"  ><i class="fa fa-info-circle"></i></button>'
               buttons += '<button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-success off-candidate" title="Activated" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-check-square-o"></i></button> ';
               buttons += '  <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert delete-candidate" title="Delete" data-type="confirm" value="'+dato.id+'"><i class="fa fa-trash-o"></i></button>';
               buttons += '  <button type="button" class="btn btn-sm btn-outline-secondary open-documents" onclick="openDocument('+dato.id+')" data-toggle="tooltip" title="Documents" value="'+dato.id+'"><i class="fa  fa-folder-open"></i></button>';

           }
           buttons+='</div>';
           return buttons;
    },
    status:function(dato){
        var status='';
        if(dato.status== 1){
            status +="<span class='badge badge-success'>Activated</span>";
        }else if(dato.status == 2){
            status +="<span class='badge badge-secondary'>Deactivated</span>";
        }
       return status;
    },
}


const success = {
    new_update: function (data,state){
     
        $('#btn-save-documents').attr('disabled', false);
        $('#btn-save').attr('disabled', false);
        $("#table-row").remove();
        $("#no-data-doc").hide();
        if(data[0]){
            var dato = data[0];
        }else{
            var dato = data;
        }
        $.notifyClose();
        switch(dato.No) {
            case 2:
                if(data[0].phone != ''){
                    $.notify({
                        // options
                        title: "Error!",
                        message:data[0].phone,
                    },{
                        // settings
                        type: 'danger'
                    });
                }

                if(data[0].email != ''){
                    $.notify({
                        // options
                        title: "Error!",
                        message:data[0].email,
                    },{
                        // settings
                        type: 'danger'
                    });
                }
            break;
            case 3:
                $.notify({
                    // options
                    title: "Saved!",
                    message:data.msg,
                },{
                    // settings
                    type: 'success'
                });

                data.documents.forEach(function(data){

                    var docs = `
                        <tr id="document_id${data.id}">
                            <td>${data.name}</td>
                            <td>${documents.button(data)}</td>
                        </tr>
                    `;
                    $('#document-list').append(docs);
                    $("#document_id"+data.id).css("background-color", "#c3e6cb");    
                });
                $("#candidate_id"+dato.id).css("background-color", "#ffdf7e");  
                var drEvent = $('#dropify-event').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                drEvent.settings.defaultFile = "";
                drEvent.destroy();
                drEvent.init();

                $('#formDocuments').trigger('reset');

                $(".dropify-preview").css('display', 'none');
            break;
        
            default:
                if(dato =='error en agregar datos.'){
                    swal({
                        title: "Datos Existentes",
                        text: "El candidate: "+candidatename+" ya existe",
                        type: "warning",
                      });
                }
                else{
                    var candidate = `<tr id="candidate_id${dato.id}">
                                        <td>${dato.name_vacancy}</td>
                                        <td>${dato.name} ${dato.last_name}</td>
                                        <td>${dato.phone}</td>
                                        <td>${dato.mail}</td>
                                        <td  style=" white-space: normal !important; word-wrap: break-word;">${dato.channel}</td>
                                        <td class="hidden-xs">${candidates.status(dato)}</td>
                                        <td>${candidates.button(dato)}</td>
                                    </tr>`;
                
                    if (state == "add"){ 
                      $("#candidate-list").append(candidate);
                      $("#candidate_id"+dato.id).css("background-color", "#c3e6cb");   
                      $('#table-row').remove(); 
                    }else{
                      $("#candidate_id"+dato.id).replaceWith(candidate);
                      $("#candidate_id"+dato.id).css("background-color", "#ffdf7e");  
                    }
        
                    $('#myModal').modal('hide')
                }  
              
            break;
        }
        
       
        
    },

    show: function(data){
        console.log(data);
        switch (data.flag) {
            case 1:
                $('#document-list').html("");
                $(".dropify-preview").css('display', 'none');
                       
                if(data.document.length === 0){
                    $("#no-data-doc").show();
                }else{
                    $("#no-data-doc").hide();

                    var document = "";
                    data.document.forEach(function(data){
                        document += `
                       
                            <tr id="document_id${data.id}">
                                <td>${data.name}</td>
                                <td>${documents.button(data)}</td>
                            </tr>
                            `;
                    })
                    $('#document-list').html(document);
                }
            break;

            case 2:
                $('#candidate_id').val(data.candidates.id);
                $('#id_vacancy').val(data.candidates.id_vacancy);
                $('#name').val(data.candidates.name);
                $('#last_name').val(data.candidates.last_name);
                $('#phone').val(data.candidates.phone);
                $('#mail').val(data.candidates.mail);
                $('#channel').val(data.candidates.channel);
                $('#listening_test').val(data.candidates.listening_test);
                $('#grammar_test').val(data.candidates.grammar_test);
                $('#typing_test').val(data.candidates.typing_test);
                $('#typing_test2').val(data.candidates.typing_test2);
                $('#typing_test3').val(data.candidates.typing_test3);
                $('#typing_test4').val(data.candidates.typing_test4);
                $('#btn-save').val("update");
                $('#myModal').modal('show');
            break;

            case 3:
                $('#candidate_id').html(data.candidates.id);
                $('#listening_test2').html(data.candidates.listening_test);
                $('#grammar_test2').html(data.candidates.grammar_test);
                $('#typing_test21').html(data.candidates.typing_test);
                $('#typing_test22').html(data.candidates.typing_test2);
                $('#typing_test23').html(data.candidates.typing_test3);
                $('#typing_test24').html(data.candidates.typing_test4);

                $('#modalDetail').modal('show');
            break;

        }

    },

    deactivated:function(data) {
        console.log(data);
        var dato = data;

        $.notifyClose();
        switch (dato.flag) {
            case 4:
                $.notify({
                    // options
                    title: "Deleted!",
                    message:dato.data.name,
                },{
                    // settings
                    type: 'danger'
                });
                $("#document_id"+dato.data.id).remove();
                var numtr = $("#table-documents tr").length;
                if(numtr ==  2){
                    $("#no-data-doc").show();
                }
            break;
        
            default:
                if(dato.status != 0){

                    var candidate = `<tr id="candidate_id${dato.id}">
                                        <td>${dato.name_vacancy}</td>
                                        <td>${dato.name} ${dato.last_name}</td>
                                        <td>${dato.phone}</td>
                                        <td>${dato.mail}</td>
                                        <td  style=" white-space: normal !important; word-wrap: break-word;">${dato.channel}</td>
                                        <td class="hidden-xs">${candidates.status(dato)}</td>
                                        <td>${candidates.button(dato)}</td>
                                    </tr>`;
                  
                    $("#candidate_id"+dato.id).replaceWith(candidate);

                    if(dato.status == 1){
                        color ="#c3e6cb";
                    }else if(dato.status == 2){
                        color ="#ed969e";
                    }
                    $("#candidate_id"+dato.id).css("background-color", color); 
        
                }else if(dato.status == 0){
                    $("#candidate_id"+dato.id).remove();

                    if($("#tag_container tr").length == 1){
                        $("#tag_container").append(` <tr id="table-row" class="text-center">
                                                            <th colspan="8" class="text-center">
                                                                <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                                                            </th>
                                                        </tr>`);
        
                    }
                }
               
                break;
        }
       
    },

    
    msj: function(data){
        console.log(data);
        $('#btn-save-documents').attr('disabled', false);        
        $.notifyClose();
        $.each(data.responseJSON.errors,function (k,message) {
            $.notify({
                // options
                title: "Error!",
                message:message,
            },{
                // settings
                type: 'danger'
            });
        });

    },

}

