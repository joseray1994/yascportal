
$(document).ready(function(){
    clearload();

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
    
    var nameDeli='<a href="/clients">Clients</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar10').addClass('active');  

    //get base URL *********************
    var url = $('#url').val();  

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })

    //display modal form for creating new product *********************
    $('#btn_add').click(function(){
        $('#labelTitle').html("New Client  <i class='fa fa-plus'></i>");
        $(".formulario").show();
        $(".formulario_contacts").hide();
        $('#btn-save').val("add");
        $(".tableClient").hide();
        $('#btn_add').hide();
        $('#formClients').trigger("reset");
        $('#tag_put').remove();
    
    });

    $('.btn-cancel').click(function(){
        $('#labelTitle').html("Clients  <i class='fa fa-briefcase'></i>");
        $(".formulario").hide();
        $(".tableClient").show();
        $('#btn_add').show();
        $(".formulario_contacts").hide();
        $('#formClients').trigger("reset");
        $('#tag_put').remove();
    
    });

    $('.btn-back').click(function(){
        $('#labelTitle').html("Clients  <i class='fa fa-briefcase'></i>");
        $(".formulario").hide();
        $(".tableClient").show();
        $('.btn-back').hide();
        $('#btn_add').show();
        $(".formulario_contacts").hide();
        $('#formContacts').trigger("reset");
        $('#tag_put').remove();
        
    });
    $('.btn-cancel-contacts').click(function(){
       
        $('#tag_put').remove();
        $('#formContacts').trigger("reset");
    });


    //Create Clients
    $("#formClients").on('submit',function (e) {
        console.log('button');
      
        e.preventDefault(); 
        var formData =  $("#formClients").serialize();
     

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var client_id = $('#client_id').val();
        var my_url = url;
        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + client_id;
           
        }
            console.log(formData);
            actions.edit_create(type,my_url,state,formData);   
          
    
    });

    //Create Contacts for Clients
    $("#formContacts").on('submit',function (e) {
        console.log('button');
      
        e.preventDefault(); 
        var formData =  $("#formContacts").serialize();

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save-contacts').val();
        var type = "POST"; //for creating new resource
        var client_id_contacts = $('#client_id_contacts').val();
        console.log(client_id_contacts);
        var my_url = url + '/contacts';
        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' +client_id_contacts;
         
        }
            console.log(formData);
            actions.edit_create(type,my_url,state,formData);   
        
            $('#formContacts').trigger("reset");
            $('#tag_put').remove();
    });

        //Edit Contact
        $(document).on('click','.btn-edit-contact',function(){
        
            $('#formClients').trigger("reset");
            $('#tag_put').remove();
            $('#btn-save-contacts').val("update");
    
            var client_id_document = $(this).val();
            var my_url = url + '/contacts/edit/' + client_id_document;
    
                actions.show(my_url);
           
        });



      //Edit Client
    $(document).on('click','.btn-edit',function(){
        $('#labelTitle').html("Edit Client  <i class='fa fa-briefcase'></i>");
        $(".formulario").show();
        $(".formulario_contacts").hide();
        $('#btn-save').val("update");
        $(".tableClient").hide();
        $('#btn_add').hide();
        $('#formClients').trigger("reset");
        $('#tag_put').remove();

        var client_id = $(this).val();
        var my_url = url + '/' + client_id;

            actions.show(my_url);
       
    });
    

    //Activate or Deactivated Clients
        $(document).on('click','.off-type',function(){
            var id = $(this).val();
            var my_url =url + '/' + id;
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
                if($(this).attr('class') == 'btn btn-sm btn-outline-success off-type')
                {
                    title= "Do you want to activate this client?";
                    text="The client will be activated";
                    confirmButtonText="Activate";

                    datatitle="Activated";
                    datatext="activated";
                    datatext2="Activation";
                }
                else 
                {
                    title= "Do you want to disable this client?";
                    text= "The client will be deactivated";
                    confirmButtonText="Deactivate";

                    datatitle="Deactivated";
                    datatext="deactivated";
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
                    swal(datatitle, "Client "+datatext, "success");
                    actions.deactivated(my_url);
                    } 
                    else {
                    
                    swal("Cancelled", datatext2+" cancelled", "error");
                
                    }
            });
        });

    //Delete Client
    $(document).on('click','.deleteClient',function(){
        var privada_id = $(this).val();
        var my_url = url + '/delete/' + privada_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Are you sure you wish to delete this client?",
            text: "The client will be deleted",
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
            }else {
               swal("Cancelled", "Deletion Canceled", "error");
            }
          });
        });

    
});

   //Add Contacts
    function add_contacs(id){
        $('#labelTitle').html(" Add Contacts  <i class='fa fa-plus'></i>");
        $(".formulario").hide();
        $(".formulario_contacts").show();
        $(".tableClient").hide();
        $('#btn_add').hide();
        $('#formContacts').trigger("reset");
        $('#tag_put').remove();
        $('#client_id_contacts').val(id);
        $('.btn-back').show();
        $('#btn_add').hide();
        //Show the contacts table
        var my_url = $('#url').val() + '/contacts/show/'+ id;
        actions.show(my_url)


    }

//Activate or Deactivated Contacts
$(document).on('click','.off-type-contacts',function(){
    var url = $('#url').val(); 
    var id = $(this).val();
    var my_url =url + '/contacts/destroy/' + id;
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
        if($(this).attr('class') == 'btn btn-sm btn-outline-success off-type-contacts')
        {
            title= "Do you want to activate this contact?";
            text="The contact will be activated";
            confirmButtonText="Activate";

            datatitle="Activated";
            datatext="activated";
            datatext2="Activation";
        }
        else 
        {
            title= "Do you want to disable this contact?";
            text= "The contact will be deactivated";
            confirmButtonText="Deactivate";

            datatitle="Deactivated";
            datatext="deactivated";
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
            swal(datatitle, "Contact "+datatext, "success");
            actions.deactivated(my_url);
            } 
            else {
            
            swal("Cancelled", datatext2+" cancelled", "error");
        
            }
    });
});

 //Delete Contact
 $(document).on('click','.deleteContact',function(){
    var url = $('#url').val();  
    var contact_id = $(this).val();
    var my_url = url + '/contacts/delete/' + contact_id;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    swal({
        title: "Are you sure you wish to delete this contact?",
        text: "The contact will be deleted",
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
        }else {
           swal("Cancelled", "Deletion Canceled", "error");
        }
      });
    });

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Constante Buttons para la tabla Clientes
const clients ={
    button: function(dato){
           var buttons='';
            if(dato.status== 1){
              
               buttons += ` <button type="button" class="btn btn-sm btn-outline-secondary btn-edit"  title="Edit"  value="${dato.id}"> <i class="fa fa-edit"></i></li></button>
                        	<button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-type"  title="Deactivated" data-type="confirm"  value="${dato.id}" ><i class="fa fa-window-close"></i></button>
                             <button type="button" class="btn btn-sm btn-outline-warning btn_add_contacts"  title="Contacts"  onclick="add_contacs(${dato.id})"> <i class="fa fa-users"></i> </button>
                             <button type="button" class="btn btn-sm btn-outline-warning open-documents" onclick="openDocument(${dato.id})"  title="Documents" value="${dato.id}"> <i class="fa fa-folder-open"></i> </button>`;
           }else if(dato.status == 2){
             
               buttons += ` <button type="button" class="btn btn-sm btn-outline-success off-type"  title="Activated" data-type="confirm"  value="${dato.id}" > <i class="fa fa-check-square-o"></i></button>
                             <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deleteClient"  title="Delete" data-type="confirm"  value="${dato.id}"> <i class="fa fa-trash-o"></i> </button>
                             <button type="button" class="btn btn-sm btn-outline-warning btn_add_contacts"  title="Contacts"  onclick="add_contacs(${dato.id})"> <i class="fa fa-users"></i> </button>
                             <button type="button" class="btn btn-sm btn-outline-warning open-documents" onclick="openDocument(${dato.id})"  title="Documents" value="${dato.id}"> <i class="fa fa-folder-open"></i> </button>`;
           }
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
//Constante Buttons para la tabla de Contactos

const contacts ={
    button: function(dato){
           var buttons='';
            if(dato.status== 1){
              
               buttons += ' <button type="button" class="btn btn-sm btn-outline-secondary btn-edit-contact" data-toggle="tooltip" title="Edit" value="'+dato.id+'"> <i class="fa fa-edit"></i></li></button>';
               buttons += ' <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deleteContact" data-toggle="tooltip" title="Delete" data-type="confirm" value="'+dato.id+'"> <i class="fa fa-trash-o"></i> </button>';
          
           }
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
    response: function(data){
        console.log(data.success)
    },
    
    new_update: function (data,state){
        $('#btn-save-documents').attr('disabled', false);
        $("#no-data-doc").hide();
        $.notifyClose();
        switch (data.No){
            case 1:
                console.log(data);
                var dato = data.client;
                var clientname =$('#name').val();
                var type =$('#type').val();
                    if (dato.description == null){
                        dato.description = "";
                    }
                    var client = `<tr id="client_id${dato.id}">
                                        <td style="background:${dato.color}"></td>
                                        <td>${dato.name}</td>
                                        <td>${dato.time_zone_name}, ${dato.time_zone_offset}</td>
                                        <td>${dato.description}</td>
                                        <td>${dato.interval}</td>
                                        <td>${dato.duration}</td>
                                        <td class="hidden-xs">${clients.status(dato)}</td>
                                        <td>${clients.button(dato)}</td>
                                    </tr>`;
                
                    if (state == "add"){ 
                        $("#client-list").append(client);
                        $("#client_id"+dato.id).css("background-color", "#c3e6cb");  
                        swal("Saved!", data.client_success, "success")  
                        $('#labelTitle').html("Client  <i class='fa fa-briefcase'></i>");
                        $(".formulario").hide();
                        $(".tableClient").show();
                        $('#btn_add').show();
                        $(".formulario_contacts").hide();
                        $('#formClients').trigger("reset");
                        $('#tag_put').remove();
                    }
                    else
                    {
                        $("#client_id"+dato.id).replaceWith(client);
                        $("#client_id"+dato.id).css("background-color", "#ffdf7e");  
                        swal("Updated!", data.client_update, "success")
                        $('#labelTitle').html("Client  <i class='fa fa-briefcase'></i>");
                        $(".formulario").hide();
                        $(".tableClient").show();
                        $('#btn_add').show();
                        $(".formulario_contacts").hide();
                        $('#formClients').trigger("reset");
                        $('#tag_put').remove();
                    }

                    
                break    
                case 2:
                    console.log(data);
                    var dato = data.contact;
                    var clientname =$('#name').val();
                    var type =$('#type').val();
                    if (dato.description == null){
                        dato.description = "";
                    }
                        var contact = `<tr id="client_id${dato.id}">
                                            <td>${dato.name}</td>
                                            <td>${dato.time_zone_name}, ${dato.time_zone_offset}</td>
                                            <td>${dato.description}</td>
                                            <td>${dato.phone}</td>
                                            <td>${dato.email}</td>
                                            <td class="hidden-xs">${contacts.status(dato)}</td>
                                            <td>${contacts.button(dato)}</td>
                                        </tr>`;
                    
                        if (state == "add"){ 
                        $("#contact-list").append(contact);
                        $("#client_id"+dato.id).css("background-color", "#c3e6cb");  
                        swal("Saved!", data.contact_success, "success")   
                        }else{
                        $("#client_id"+dato.id).replaceWith(contact);
                        $("#client_id"+dato.id).css("background-color", "#ffdf7e");  
                        swal("Saved!", data.contact_updated, "success")   
                        }
                break        
                case 3:
                    var dato = data;
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
                    $("#client_id"+dato.id).css("background-color", "#ffdf7e");  
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

        }
    },

    deactivated:function(data) {
        switch (data.flag){
            case 1:
                console.log(data.client);
                var dato = data.client;
                if(dato.status != 0){
                    if(dato.description == null){
                        dato.description = '';
                    }
                    var client = `<tr id="client_id${dato.id}" >
                                         <td style="background:${dato.color}"></td>
                                         <td>${dato.time_zone_name}, ${dato.time_zone_offset}</td>
                                        <td>${dato.name}</td>
                                        <td>${dato.description}</td>
                                        <td>${dato.interval}</td>
                                        <td>${dato.duration}</td>
                                        <td class="hidden-xs">${clients.status(dato)}</td>
                                        <td>${clients.button(dato)}</td>
                                    </tr>`;
          
                $("#client_id"+dato.id).replaceWith(client);
                if(dato.status == 1){
                    color ="#c3e6cb";
                }else if(dato.status == 2){
                    color ="#ed969e";
                }
                $("#client_id"+dato.id).css("background-color", color); 

            }else if(dato.status == 0){
                $("#client_id"+dato.id).remove();
                swal("Deleted!", data.client_deleted, "success")
            }
            break;
            case 2:
               
                var dato = data.contact;
                if(dato.status != 0){
                    var contact = `<tr id="client_id${dato.id}">
                                        <td>${dato.name}</td>
                                        <td>${dato.description}</td>
                                        <td>${dato.phone}</td>
                                        <td>${dato.email}</td>
                                        <td class="hidden-xs">${contacts.status(dato)}</td>
                                        <td>${contacts.button(dato)}</td>
                                    </tr>`;
          
                $("#client_id"+dato.id).replaceWith(contact);
                if(dato.status == 1){
                    color ="#c3e6cb";
                }else if(dato.status == 2){
                    color ="#ed969e";
                }
                $("#client_id"+dato.id).css("background-color", color); 

            }else if(dato.status == 0){
                $("#client_id"+dato.id).remove();
                swal("Deleted!", data.contact_deleted, "success")
            }
            break;
            case 4:
                dato = data;
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
                var contact = "";
                data.contact.forEach(function(data){
                    if(data.description == null){
                        data.description = "";
                    }
                    contact += `
                   
                        <tr id="client_id${data.id}">
                            <td>${data.name}</td>
                            <td>${data.description}</td>
                            <td>${data.phone}</td>
                            <td>${data.email}</td>
                            <td class="hidden-xs">${contacts.status(data)}</td>
                            <td>${contacts.button(data)}</td>
                        </tr>
                        `;
                })
                $('#contact-list').html(contact);
            break;
            case 3:
            
            var document = "";
            data.document.forEach(function(data){
                document += `
               
                    <tr id="client_id${data.id}">
                        <td>${data.name}</td>
                        <td>${documents.button(data)}</td>
                    </tr>
                    `;
            })
            $('#document-list').html(document);
            break;
            case 4:
            var data = data.contact_edit;
            console.log(data)   
                $('#client_id_contacts').val(data.id);
                $('#name_contact').val(data.name);
                $('#description_contact').val(data.description);
                $('#email_contact').val(data.email);
                $('#phone_contact').val(data.phone);
                $('#btn-save-contacts').val("update");
            break;
            case 5:
                 var data = data.client;
                console.log(data);
                $('#client_id').val(data.id_client);
                $('#name').val(data.name);
                $('#time_zone').val(data.id_time_zone);
                $('#description').val(data.description);
                $('#color').val(data.color);
                $('#interval').val(data.interval);
                $('#duration').val(data.duration);
                $('#myModal').modal('show');
            break

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



    
function newFunction() {
    return '#url';
}

