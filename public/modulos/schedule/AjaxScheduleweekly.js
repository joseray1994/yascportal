
$(document).ready(function(){
     
    schedule.get_data(1);
    var nameDeli='<a href="/weekly">Schedule Weekly</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar5').addClass('active') 

    //get base URL *********************
    var url = $('#url').val();
    $('.js-example-basic-single').select2();
    $('.js-example-basic-multiple').select2();

    //display modal form for creating new product *********************
    $('#btn_add').click(function(){
        $('#btn-save').val("add");
        $('#days').val(null).trigger('change');
        $('#typeUserForm').trigger("reset");
        $("#image").attr('src','');
        $('#myModal2').modal('show');
    });

    $('.cancel_data').click(function(){
        $('#btn-save').val("add");
        $('#days').val(null).trigger('change');
        $('#typeUserForm').trigger("reset");
        $("#image").attr('src','');
        $('#myModal2').modal('hide');
        $('#myModal').modal('hide');
    });

    $('.scheduleWeeklySearch').change(function(){
        schedule.get_data(1);
    });



    //display modal form for product EDIT ***************************
    $(document).on('click','.open_modal',function(){
        $('#typeUserForm').trigger("reset");
        var usertype_id = $(this).val();
        var my_url = url + '/' + usertype_id;

            actions.show(my_url);
       
    });


    //create new product / update existing product ***************************
    $("#typeUserForm").on('submit',function (e) {
        e.preventDefault(); 
        var formData =  schedule.dataSend();
        
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var usertype_id = $('#usertype_id').val();;
        var my_url = url;
        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + usertype_id;
        }
        
            console.log(formData);
        
            actions.edit_create(type,my_url,state,formData);
    
    });

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
                    title= "¿Deseas activar este Usuario?";
                    text="El Usuario se activara";
                    confirmButtonText="Activar";

                    datatitle="Activado";
                    datatext="activado";
                    datatext2="Activacion";
                }
                else 
                {
                    title= "¿Desea desactivar este Usuario?";
                    text= "El Usuario se desactivara";
                    confirmButtonText="Desactivar";

                    datatitle="Desactivado";
                    datatext="desactivado";
                    datatext2="Desactivacion";

                }
    

                swal({
                    title: title,
                    text: text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn btn-danger",
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                    swal(datatitle, "Usuario "+datatext, "success");
                    actions.deactivated(my_url);
                    } 
                    else {
                    
                    swal("Cancelado", datatext2+" cancelada", "error");
                
                    }
            });
        });

    //delete product and remove it from TABLE list ***************************
    $(document).on('click','.delete-profile',function(){
        var privada_id = $(this).val();
        var my_url = url + '/delete/' + privada_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "¿Desea eliminar este Usuario?",
            text: "El usuario se eliminara permanentemente",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: true,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {
                actions.deactivated(my_url);
            }else {
               swal("Cancelado", "Eliminacion cancelada", "error");
            }
          });
        });


    //display modal form for product DETAIL ***************************
    $(document).on('click','.open_detail',function(){
        var usertype_id = $(this).val();
       
        // Populate Data in Edit Modal Form
        $.ajax({
            type: "GET",
            url: url + '/' + usertype_id,
            success: function (data) {
                console.log(data);
                $(".modal-body-detail").html(data);
                $('#myModal2').modal('show');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
});
const schedule ={
    button: function(dato){
           var buttons='';
            if(dato.status== 1){
               buttons +='<a class="btn btn-sm btn-outline-primary" title="Assignament Type" id="btn-edit" href="/assignmenttype/'+dato.id+'"  ><i class="fa fa-info-circle"></i></a>'
               buttons += ' <button class="btn btn-sm btn-secondary btn-detail open_modal"  data-toggle="tooltip" title="Editar nombre del Perfil"  value="'+dato.id+'"> <i class="fa fa-edit"></i></li></button>';
               buttons += '	<button type="button" class="btn btn-sm btn-outline-danger off-type" title="Desactivar Usuario" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-window-close"></i></button>';
          
           }else if(dato.status == 2){
               buttons+='<button type="button" class="btn btn-sm btn-outline-success off-type" title="Activar Usuario" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-check-square-o"></i></button>'
               buttons += '<button class="btn btn-danger btn-sm btn-delete delete-profile" data-toggle="tooltip" title="Desactivar Perfil" value="'+dato.id+'"><i class="fa fa-trash-o"></i> </button>';
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
    get_data: function(page){
            var formData={
                day: $('#daySearch').val(),
                client:$('#clientSearch').val(),
                date:$('#dateSearch').val(),
                operator:$('#operatorSearch').val(),
            }
            console.log(formData);
            $.ajax(
            {
                url: '?page=' + page,
                data:formData,
                type: "get",
                datatype: "html"
            }).done(function(data){
                $('.pagination').remove();
                $("#tag_container").empty().html(data);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                  alert('No response from server');
            });
        },
    dataSend: function(){
        n="";
        t=""
        if($("#now").prop("checked") == true){
            n+=$("#now").val();
        }
        if($("#today").prop("checked") == true){
            t+=$("#today").val();
        }
        var data =  {
                time_start:$('#time_start').val(),
                time_end:$('#time_end').val(),
                days:$("#days").val(),
                time_extra:$('#time_extra').val(),
                durationH:$("#durationH").val(),
                durationM:$("#durationM").val(),
                now:n,
                today:t,
        }
     
        return data;
    },
    selectClient: function(){
        select="";
        $.each(data, function(idx, ope) {
            var select=`<option value="${ope.id}">${ope.name}</option>`;
        });
    }
    
}
const success = {

    new_update: function (data,state){
        console.log(data);
        var dato = data;
        var typename =$('#name').val();
        
        if(dato =='error en agregar datos.'){
            swal({
                title: "Datos Existentes",
                text: "El perfil: "+typename+" ya existe",
                type: "warning",

              });
        }
        else{
            var profile = `<tr id="usertype_id${dato.id}">
                                <td>${dato.id}</td>
                                <td>${dato.name}</td>
                                <td class="hidden-xs">${types.status(dato)}</td>
                                <td>${types.button(dato)}</td>
                            </tr>`;
        
            if (state == "add"){ 
              $("#usertype-list").append(profile);
              $("#usertype_id"+dato.id).css("background-color", "#c3e6cb");    
            }else{
              $("#usertype_id"+dato.id).replaceWith(profile);
              $("#usertype_id"+dato.id).css("background-color", "#ffdf7e");  
            }

            $('#myModal').modal('hide')
        }
        
    },

    deactivated:function(data) {
        console.log(data);
        var dato = data;
        if(dato.status != 0){
            var profile = `<tr id="usertype_id${dato.id}">
                                <td>${dato.id}</td>
                                <td>${dato.name}</td>
                                <td class="hidden-xs">${types.status(dato)}</td>
                                <td>${types.button(dato)}</td>
                            </tr>`;
          
            $("#usertype_id"+dato.id).replaceWith(profile);
            if(dato.status == 1){
                color ="#c3e6cb";
            }else if(dato.status == 2){
                color ="#ed969e";
            }
            $("#usertype_id"+dato.id).css("background-color", color);  
            
        }else if(dato.status == 0){
            $("#usertype_id"+dato.id).remove();
        }
       
    },

    show: function(data){
        console.log(data);
    
      
        if(data.detail.type == 2){
            $('#btn-saveE').val("update");
            $('#usertype_idE').val(data.detail.id);
            $('#time_startE').val(data.detail.time_s);
            $('#time_endE').val(data.detail.time_e);
            $('#myModal2').modal('show');
            
        }else{
            $('#btn-save').val("update");
            $('#usertype_id').val(data.detail.id);
            $('#time_start').val(data.detail.time_s);
            $('#time_end').val(data.detail.time_e);
    
            if(data.days.length == 0){
                $('#days').val(null);
                $('#days').trigger('change');
            }else{
    
                var select="";
                $('#days').val(data.days)
                $('#days').trigger('change');
            }
            $('#myModal').modal('show');
        }
        
        
    },

    msj: function(data){
        console.log(data);
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



    
