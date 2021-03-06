
var url = $('#url').val();
var baseUrl = $('#baseUrl').val();
$(document).ready(function(){
    clearload();
    // var rowCount = $('#tag_container tr').length;
    // console.log(rowCount);
    //get base URL *********************
    // $('.selectpick').selectpicker({
    //     liveSearchPlaceholder: 'Search Client'
    // });
    $(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            }else{
                get_data(page);
            }
        }
    });

    $("#name, #last_name").keyup(function(){
        flag = $("#flag").val();
        if(flag === "false"){

            $("#nickname").val("");
            $(".seccion-sugerencia").hide();
            $(".segunda-seccion").hide();
            $("#nickname").attr('disabled', true);
        }
    });

    var radioState;
    $('#sidebar2').addClass('active'); 
    $('.selectpick').selectpicker('refresh');
    $('#myTable').DataTable();
    $(".pass").hide();
    $(".clients").hide();
    $('.stage').hide();
    $('#id_stage').attr('disabled','disabled');
    $('.cafeteria').hide();
    $('#id_cafeteria').attr('disabled','disabled');

    function getClients()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })       
        $.ajax({
            type: 'GET',
            url: baseUrl+'/getClients',
            dataType: 'json',
            success: function (data) {
              console.log(data);
              var html = '';
              $.each(data, function (key, val) {
                  html+= "<option value='"+val.id+"'>"+ val.name+"</option>"
                
                // $('.selectpick option[value=' + val.id + ']');
            });
            $('#clients').html(html); 
            
            },
            error: function (data) {
                console.log(data);
                

            }
            }); 
    }

    function disablePassInput()
    {
        $('#password').attr('disabled','disabled');
        $('#confirm_password').attr('disabled','disabled');
    }

    function enablePassInput()
    {
        $('#password').removeAttr('disabled');
        $('#confirm_password').removeAttr('disabled');
    }

    $('#id_type_user').change(function(){
        var teamLeader = $(this).val();

        if(teamLeader == 2)
        {
            $(".clients").show();
        }
        else
        {
            $(".clients").hide();
        }
    });

    $("#show_pass").on("click", function(e) {
        if (radioState === this) {
            $(".pass").hide();
            disablePassInput()
            this.checked = false;
            radioState = null;
        } else {
            $(".pass").show();
            enablePassInput()
            console.log("false");
            radioState = this;
        }
    });


    //display modal form for creating new product *********************
    $('#btn_add').click(function(){
        $('.selectpick').selectpicker("deselectAll");
        $('#myModalLabel').html("Agregar Usuario  <i class='fa fa-tasks'></i>");
        var drEvent = $('#dropify-event').dropify();
        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();
        drEvent.clearElement();
        $(".clients").hide();
        drEvent.settings.defaultFile = "";
        drEvent.destroy();
        drEvent.init();
        enablePassInput();
        $('#btn_add').hide();
        $('.formulario').show();
        $('.tableUser').hide();
        $('#tag_put').remove();
        $('.stage').hide();
        $('.cafeteria').hide();
        $('#btn-save').val("add");
        $('#userForm').trigger("reset");
        $(".pass").show();
        $(".show_pass_div").hide();
        $('.selectpick').selectpicker("deselectAll");
        $(".seccion-sugerencia").hide();
        $(".segunda-seccion").hide();
        $("#nickname").attr('disabled', true);
        $('.btnGenerate').show();
        $("#flag").val(false);
        // $('#myModal').modal('show');
    
    });

    $('.btn-cancel').click(function(){
        $('.formulario').hide();
        $('#btn_add').show();
        $(".clients").hide();
        $('.tableUser').show();        
    });

    //display modal form for product EDIT ***************************
    $(document).on('click','#btn-edit',function(){
        getClients();
        $('#myModalLabel').html("Editar Usuario <i class='fa fa-tasks'></i>");
        var drEvent = $('#dropify-event').dropify();
        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();
        drEvent.clearElement();
        // $(".clients").hide();
        drEvent.settings.defaultFile = "";
        drEvent.destroy();
        drEvent.init();
        $('#userForm').trigger("reset");
        $('#btn_add').hide();
        $('.formulario').show();
        $('.tableUser').hide();
        disablePassInput()
        $('#tag_put').remove();
        $('.btnGenerate').hide();
        $form = $('#userForm');
        $form.append('<input type="hidden" id="tag_put" name="_method" value="PUT">');
        // $('#myModal').modal('show');
        $(".show_pass_div").show();
        $(".pass").hide();
        var id_user = $(this).val();
        $(".seccion-sugerencia").hide();
        $(".segunda-seccion").show();
        $("#nickname").attr('disabled', false);
        $("#email").attr('disabled', true);
        $("#flag").val(true);
        $('#id_user').val(id_user);
        var my_url= baseUrl + '/users/' + id_user;
        actions.show(my_url);
    });

        //create new product / update existing product ***************************
    $("#userForm").on('submit',function (e) {
        $('#btn-save').attr('disabled', true);
        e.preventDefault(); 
        var stageArray=[];
        var formData = new FormData(this);
        var id_user = $('#id_user').val();
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var my_url = baseUrl+'/users';
        if (state == "update")
        {
            my_url=baseUrl + '/users/' + id_user;
        }

        actions.edit_create(type,my_url,state,formData,'file');
                    
    });

    $(".allownumericwithdecimal").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
       
    //DELETE
    $(document).on('click','.delete-op',function(){
        var id = $(this).val();
        var my_url = baseUrl + '/users/' + id;
        console.log(my_url)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
        if($(this).attr('class') == 'btn btn-sm btn-outline-success delete-op'){
            title= "Do you want to activate this user?";
            text="User will be activated";
            confirmButtonText="Activate";

            datatitle="Activated";
            datatext="activated";
            datatext2="Activation";
        }else {
            title= "Do you want to disable this user?";
            text= "User will be deactivated";
            confirmButtonText="Desactivar";

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
                swal(datatitle, "Option "+datatext, "success");
                actions.deactivated(my_url);
            } 
            else {
            swal("Cancelled", datatext2+" cancelled", "error");
            }
        });
    });

    $(document).on('click','.destroy-op',function(){
        var id = $(this).val();
        var my_url = url + '/delete/' + id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Are you sure you wish to delete this option?",
            text: "All records with this option will be modified",
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

    $("#btn-nick-generate").click(function(e){
        e.preventDefault();

        var name = $("#name").val();
        var last_name = $("#last_name").val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            type:"POST",
            url:baseUrl+'/generate',
            data:{name:name, last_name:last_name},
            dataType:"json",
            success: function(data){
                var html = "";
                $.notifyClose();
                if(data.No){
                    $.notify({
                        // options
                        title: "Error!",
                        message:data.msg,
                    },{
                        // settings
                        type: 'danger'
                    });
                }else{
                    html += `<option value="">Seleccionar</option> `;
                    html += `<option value="0">None</option> `;
                    data.forEach(function(data){
                        html += `<option value="${data}">${data}</option> `;
                    });
                    $("#sugerencias").html(html);
                    $(".seccion-sugerencia").show();
                }
            },
            error: function(err){
                $(".seccion-sugerencia").hide();
                console.log(err);
            }
        });
    });

    $("#sugerencias").change(function(){
        valor = $(this).val();
        if(valor != 0 || valor != ""){
            if(valor == 0){
                valor = "";
            }
            $("#nickname").val(valor);
            $("#nickname").attr('disabled', false);
            $("#email").val(valor+'@yascemail.com');
            $("#email").attr('disabled', false);
            $("#password").val(valor + "*2020");
            $("#password_confirmation").val(valor + "*2020");
            $(".segunda-seccion").show();
        }else{
            $(".segunda-seccion").hide();
            $("#nickname").val("");
            $("#email").val("");
            $("#password").val("");
            $("#password_confirmation").val("");
            
        }
    });

    $("#nickname").keyup(function(){

        flag = $("#flag").val();

        if(flag === "false"){
            nickname = $(this).val();
            nickname = nickname.toLowerCase();
            if(nickname != ""){
                $("#email").val(nickname+'@yascemail.com');
                $("#password").val(nickname + "*2020");
                $("#password_confirmation").val(nickname + "*2020");
            }else{
                $("#nickname").val("");
                $("#email").val('@yascemail.com');
                $("#password").val("*2020");
                $("#password_confirmation").val("*2020");
            }
        }

    });

    $(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
        $(this).val($(this).val().replace(/[^\d].+/, ""));
         if ((event.which < 48 || event.which > 57)) {
             event.preventDefault();
         }
     });


    
 });      


     
 const category={
    status: function (dato){
        if(dato.user.id_status== 1){
            statu="<span class='badge badge-success'>Activo</span>";
    
        }else{
            statu="<span class='badge badge-secondary'>Inactivo</span>";
        }
    
        return statu;
        },
    buttons:function(dato){
   
// console.log(dato)
        var buttons='<div>';
        if(dato.id_status== 1){
        buttons += ` <button type="button" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="${dato.id}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert delete-op" data-toggle="tooltip" title="Desactivated" data-type="confirm" value="${dato.id}"><i class="fa fa-window-close"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary open-documents" onclick="openDocument('${dato.id}')" data-toggle="tooltip" title="Documents" value="${dato.id}"><i class="fa  fa-folder-open"></i></button>
        ` ;

        }else if(dato.id_status == 2){
        buttons  += `<button type="button" class="btn btn-sm btn-outline-success delete-op" title="Activated" data-toggle="tooltip" data-type="confirm" value="${dato.id}" ><i class="fa fa-check-square-o"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert destroy-op" data-toggle="tooltip" title="Delete" data-type="confirm" value="${dato.id}"><i class="fa fa-trash-o"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary open-documents" onclick="openDocument('${dato.id}')" data-toggle="tooltip" title="Documents" value="${dato.id}"><i class="fa  fa-folder-open"></i></button>`
                    
                    }
        buttons+='</div>';
        return buttons;
    }

}

const types ={
    button: function(dato){
           var buttons='<div>';
            if(dato.id_status== 1){
                buttons += ` <button type="button" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="${dato.id}"  ><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert delete-op" data-toggle="tooltip" title="Desactivated" data-type="confirm" value="${dato.id}"><i class="fa fa-window-close"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary open-documents" onclick="openDocument('${dato.id}')" data-toggle="tooltip" title="Documents" value="${dato.id}"><i class="fa  fa-folder-open"></i></button>
                           ` ;
          
           }else if(dato.id_status == 2){
            buttons  += `<button type="button" class="btn btn-sm btn-outline-success delete-op" title="Activated" data-toggle="tooltip" data-type="confirm" value="${dato.id}" ><i class="fa fa-check-square-o"></i></button>
            <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert destroy-op" data-toggle="tooltip" title="Delete" data-type="confirm" value="${dato.id}"><i class="fa fa-trash-o"></i></button>
            <button type="button" class="btn btn-sm btn-outline-secondary open-documents" onclick="openDocument('${dato.id}')" data-toggle="tooltip" title="Documents" value="${dato.id}"><i class="fa  fa-folder-open"></i></button>`;
           }
           buttons+='</div>';
           return buttons;
    },
    status:function(dato){
        var status='';
        if(dato.id_status== 1){
            status +="<span class='badge badge-success'>Activated</span>";
        }else if(dato.id_status == 2){
            status +="<span class='badge badge-secondary'>Deactivated</span>";
        }
       return status;
    },
}
 


const success = { 
    new_update: function (data,state){
            console.log(data);
            $('#btn-save-documents').attr('disabled', false);
            $('#btn-save').attr('disabled', false);
            $("#no-data-doc").hide();
            var dato = data;
            $.notifyClose();
            var dato = data;
            switch(dato.No) {
                case 2:
                    $.notify({
                        // options
                        title: "Error!",
                        message:data.msg,
                    },{
                        // settings
                        type: 'danger'
                    });
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
                $("#user_id"+dato.id).css("background-color", "#ffdf7e");  
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
                if (state == "add")
                { //if user added a new record
                    swal({
                        title: dato.user_info.name,
                        text: "Usuario añadido",
                        type: "success",
                        button: "OK",
                    });
                
                    var user = `<tr id="user_id${dato.id}">
                                    <td>${dato.id}</td>
                                    <td>${dato.user_info.name}</td>
                                    <td>${dato.user_info.last_name}</td>
                                    <td>${dato.email}</td>
                                    <td>${dato.user_info.phone}</td>
                                    <td>${dato.type_user.name}</td>
                                    <td>${dato.user_info.entrance_date}</td>
                                    <td>${dato.user_info.birthdate}</td>
                                    <td class="hidden-xs">${types.status(dato)}</td>
                                    <td>${types.button(dato)}</td>
                                </tr>`;
            
        
                    $('.formulario').hide();
                    $('.tableUser').show(); 
                    $("#user-list").append(user);
                    $('#btn_add').show();
                    $("#user_id"+dato.id).css("background-color", "#c3e6cb");    

                
                }
                else
                { //if user updated an existing record
                    swal({
                        title: dato.user_info.name,
                        text: "Usuario modificado",
                        type: "success",
                        button: "OK",
                    });

                    var user = `<tr id="user_id${dato.id}">
                                    <td>${dato.id}</td>
                                    <td>${dato.user_info.name}</td>
                                    <td>${dato.user_info.last_name}</td>
                                    <td>${dato.email}</td>
                                    <td>${dato.user_info.phone}</td>
                                    <td>${dato.type_user.name}</td>
                                    <td>${dato.user_info.entrance_date}</td>
                                    <td>${dato.user_info.birthdate}</td>
                                    <td class="hidden-xs">${types.status(dato)}</td>
                                    <td>${types.button(dato)}</td>
                                </tr>`;

                    $('.formulario').hide();
                    $('.tableUser').show(); 
                    $("#user_id"+dato.id).replaceWith(user);
                    $('#btn_add').show();
                    $("#user_id"+dato.id).css("background-color", "#ffdf7e"); 
                }
                $('#userForm').trigger("reset");
                $('#myModal').modal('hide');

                break;
        

            }
            
                
        },
    show: function(data){
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
        
            default:
                if(data.id_type_user == 2) $(".clients").show();
                $.each(data.clients, function (key, val) {
                    $('.selectpick option[value=' + val.id_client + ']').attr('selected', true);
                });
                $('.selectpick').selectpicker('refresh'); 
                var rutaImage = baseUrl + '/images/users/' + data.user_info.profile_picture;
                  
                var drEvent = $('#dropify-event').dropify(
                    {
                        defaultFile: rutaImage
                    });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = rutaImage;
                    drEvent.destroy();
                    drEvent.init();
                $('#name').val(data.user_info.name);
                $('#last_name').val(data.user_info.last_name);
                $('#nickname').val(data.nickname);
                $('#address').val(data.user_info.address);
                $('#phone').val(data.user_info.phone);
                $('#emergency_contact_name').val(data.user_info.emergency_contact_name);
                $('#emergency_contact_phone').val(data.user_info.emergency_contact_phone);
                $('#id_type_user').val(data.id_type_user);
                $('#entrance_date').val(data.user_info.entrance_date);
                $('#birthdate').val(data.user_info.birthdate);
                $('#gender').val(data.user_info.gender);
                $('#description').val(data.user_info.description);
                $('#email').val(data.email);
                $('#btn-save').val("update");
                $('#myModal').modal('show');
                break;
        }

        console.log(data)
        
    },
    deactivated:  function(data){
        console.log(data)
        var dato = data;
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
                if(dato.id_status != 0){

                    var user = `<tr id="user_id${dato.id}">
                    <td>${dato.id}</td>
                    <td>${dato.user_info.name}</td>
                    <td>${dato.user_info.last_name}</td>
                    <td>${dato.email}</td>
                    <td>${dato.user_info.phone}</td>
                    <td>${dato.type_user.name}</td>
                    <td>${dato.user_info.entrance_date}</td>
                    <td>${dato.user_info.birthdate}</td>
                    <td class="hidden-xs">${types.status(dato)}</td>
                    <td>${types.button(dato)}</td>
                </tr>`;
                  
                    $("#user_id"+dato.id).replaceWith(user);
                    if(dato.id_status == 1){
                        color ="#c3e6cb";
                    }else if(dato.id_status == 2){
                        color ="#ed969e";
                    }
                    $("#user_id"+dato.id).css("background-color", color);  
                    
                }else if(dato.id_status == 0){
                    
                    $("#user_id"+dato.id).remove();
                    if ($('.rowType').length == 0) {
                        $('#table-row').show();
                      }
                }
               
                break;
        }      
        },
        msj: function(data){
            $('#btn-save').attr('disabled', false);
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
                $('#name').addClass('border-dange');
            });
            
        }
}
       