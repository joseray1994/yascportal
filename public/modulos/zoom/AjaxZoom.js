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

    var nameDeli='<a href="/zoom">Zoom</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar10').addClass('active');  

    var url = $('#url').val();

     //change view to create zoom
     $('#btn_add').click(function(){
        $('#labelTitle').html("New Zoom  <i class='fa fa-video-camera'></i>");
        $(".formulario-zoom").show();
        $(".tableZoom").hide();
        $('#btn-save').val("add");
        $('#btn_add').hide();
        $('#formZoom').trigger("reset");
        $('#tag_put').remove();
    
    });
    //back to zoom table
    $('.btn-cancel').click(function(){
        $('#labelTitle').html("Zoom  <i class='fa fa-video-camera'></i>");
        $(".formulario-zoom").hide();
        $(".tableZoom").show();
        $('#btn_add').show();
        $('#formZoom').trigger("reset");
        $('#tag_put').remove();
    
    });
    //open modal to assign user
    $(document).on('click','.open_modal',function(){
        $('#myModal').modal('show');
        var id = $(this).val();
        $('#addUser').val(id);
        $('#tag_put').remove();
    });

     //Assign user 
     $("#assignForm").on('submit',function (e) {
        console.log('button');
      
        e.preventDefault(); 
        var formData =  $("#assignForm").serialize();
       var state = $('#btn-save-user').val();
        var type = "PUT"; 
        var my_url = url;
        var id = $('#addUser').val();
        my_url += '/assign/' + id;

        console.log(formData);
        actions.edit_create(type,my_url,state,formData);   
          
    });

    //Create/Update Zoom
    $("#formZoom").on('submit',function (e) {
    
        e.preventDefault(); 
        var formData =  $("#formZoom").serialize();
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; 
        var zoom_id = $('#zoom_id').val();
        var my_url = url;
        if (state == "update"){
            type = "PUT"; 
            my_url += '/' + zoom_id;
           
        }
            actions.edit_create(type,my_url,state,formData);   
    
    });

    //Edit Zoom
      $(document).on('click','.btn-edit',function(){
        $('#labelTitle').html("Edit Zoom  <i class='fa fa-video-camera'></i>");
        $(".tableZoom").hide();
        $(".formulario-zoom").show();
        $('#btn-save').val("update");
        $('#btn_add').hide();
        $('#formZoom').trigger("reset");
        $('#tag_put').remove();

        var zoom_id = $(this).val();
        var my_url = url + '/' + zoom_id;

            actions.show(my_url);
       
    });

        //Activate or Deactivated Zoom
        $(document).on('click','.off-type',function(){
            var id = $(this).val();
            var my_url =url + '/deactivate/' + id;
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
                if($(this).attr('class') == 'btn btn-sm btn-outline-success off-type')
                {
                    title= "Do you want to activate this zoom?";
                    text="The zoom will be activated";
                    confirmButtonText="Activate";

                    datatitle="Activated";
                    datatext="activated";
                    datatext2="Activation";
                }
                else 
                {
                    title= "Do you want to disable this zoom?";
                    text= "The zoom will be deactivated";
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
                    swal(datatitle, "Zoom "+datatext, "success");
                    actions.deactivated(my_url);
                    } 
                    else {
                    
                    swal("Cancelled", datatext2+" cancelled", "error");
                
                    }
            });
        });


    //Delete Zoom
    $(document).on('click','.deletezm',function(){
        var id = $(this).val();
        var my_url = url + '/delete/' + id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Are you sure you wish to delete this zoom?",
            text: "The zoom will be deleted",
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

      //Activate or Deactivated Zoom
      $(document).on('click','.leave_zoom',function(){
        var id = $(this).val();
        var url = $('#url').val();
        var my_url =url + '/free/' + id;

        swal({
            title: "Do you want to leave this zoom?",
            text: "The zoom will be available",
            type: "info",
            showCancelButton: true,
            confirmButtonClass: "btn-succes",
            confirmButtonText: "Leave Zoom",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {
              var state = $('#quiUser').val("update");
              var type = "PUT"; 
              actions.edit_create(type,my_url,state);   
             
            } else {
              swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
          });
           
           
    });



const zooms ={
    button: function(dato){
           var buttons='';
            if(dato.status== 1){
              
                buttons += `
                            <button type="button" class="btn btn-sm btn-outline-warning open_modal" id = "addUser"   title="Assing Zoom"  value="${dato.id}"  ><i class="fa fa-video-camera"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-edit"  title="Edit"  value="${dato.id}"  ><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-type"  title="Deactivated" data-type="confirm" value="${dato.id}"><i class="fa fa-window-close"></i></button>`;
          
           }
           else if(dato.status == 2){
             
            buttons += `
                         <button type="button" class="btn btn-sm btn-outline-success off-type"  title="Activated" data-type="confirm" value="${dato.id}" ><i class="fa fa-check-square-o"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deletezm"  title="Delete" data-type="confirm"  value="${dato.id}"> <i class="fa fa-trash-o"></i> </button>`;
        }
        if(dato.status== 3){
              
            buttons += ` <button type="button" class="btn btn-sm btn-outline-success leave_zoom" id = "quitUser"  title="Leave Zoom"  value="${dato.id}"  ><i class="fa fa-video-camera"></i></button>
                       `;
      
       }
           return buttons;
    },
    status:function(dato){
        var status='';
        if(dato.status== 1){
            status +="<span class='badge badge-success'>Available</span>";
        }else if(dato.status == 2){
            status +="<span class='badge badge-danger'>Deactivated</span>";
        }
        else if(dato.status == 3){
        status +="<span class='badge badge-secondary'>In use</span>";
    }
       return status;
    },
}


  
const success = {
    new_update: function (data,state){
        $("#no-data-doc").hide();
        $.notifyClose();
        switch (data.flag){
            case 1:
                console.log(data);
                var dato = data.zoom;
                if(dato.in_use_by == null){
                    dato.in_use_by = '';
                }
                    var zoom = `<tr id="zoom_id${dato.id}">
                                        <td>${dato.name}</td>
                                        <td>${dato.email}</td>
                                        <td>${dato.password}</td>
                                        <td>${dato.in_use_by}</td>
                                        <td class="hidden-xs">${zooms.status(dato)}</td>
                                        <td>${zooms.button(dato)}</td>
                                    </tr>`;
                
                    if (state == "add"){ 
                        $("#zoom-list").append(zoom);
                        $("#zoom_id"+dato.id).css("background-color", "#c3e6cb");  
                        swal("Saved!", data.zoom_success, "success")  
                        $('#labelTitle').html("Zoom  <i class='fa fa-video-camera'></i>");
                        $(".formulario-zoom").hide();
                        $(".tableZoom").show();
                        $('#btn_add').show();
                        $('#formZoom').trigger("reset");
                        $('#tag_put').remove();
                    }
                    else
                    {
                        $("#zoom_id"+dato.id).replaceWith(zoom);
                        $("#zoom_id"+dato.id).css("background-color", "#ffdf7e");  
                        swal("Updated!", data.zoom_update, "success")
                        $('#labelTitle').html("Zoom  <i class='fa fa-video-camera'></i>");
                        $(".formulario-zoom").hide();
                        $(".tableZoom").show();
                        $('#btn_add').show();
                        $('#formZoom').trigger("reset");
                        $('#tag_put').remove();
                    }
                break;    

                case 2:
                console.log(data);
                var dato = data.zoom;
                if(dato.in_use_by == null){
                    dato.in_use_by = '';
                }
                    var zoom = `<tr id="zoom_id${dato.id}">
                                        <td>${dato.name}</td>
                                        <td>${dato.email}</td>
                                        <td>${dato.password}</td>
                                        <td>${dato.in_use_by}</td>
                                        <td class="hidden-xs">${zooms.status(dato)}</td>
                                        <td>${zooms.button(dato)}</td>
                                    </tr>`;
                
                   
                        $("#zoom_id"+dato.id).replaceWith(zoom);
                        $("#zoom_id"+dato.id).css("background-color", "#ffdf7e");  
                        swal("Assigned!", data.user_update, "success")
                        $('#labelTitle').html("Zoom  <i class='fa fa-video-camera'></i>");
                        $(".formulario-zoom").hide();
                        $(".tableZoom").show();
                        $('#btn_add').show();
                        $('#tag_put').remove();
                        $('#myModal').modal('hide');
                
                break; 
                case 3:
                    console.log(data);
                    var dato = data.zoom;
                    if(dato.in_use_by == null){
                        dato.in_use_by = '';
                    }
                        var zoom = `<tr id="zoom_id${dato.id}">
                                            <td>${dato.name}</td>
                                            <td>${dato.email}</td>
                                            <td>${dato.password}</td>
                                            <td>${dato.in_use_by}</td>
                                            <td class="hidden-xs">${zooms.status(dato)}</td>
                                            <td>${zooms.button(dato)}</td>
                                        </tr>`;
                    
                       
                            $("#zoom_id"+dato.id).replaceWith(zoom);
                            $("#zoom_id"+dato.id).css("background-color", "#ffdf7e");  
                            swal("Available!", data.user_update, "success")
                            $('#labelTitle').html("Zoom  <i class='fa fa-video-camera'></i>");
                            $(".formulario-zoom").hide();
                            $(".tableZoom").show();
                            $('#btn_add').show();
                            $('#tag_put').remove();
                    break; 
                
        }
    },


    show: function(data){
        console.log(data);
        switch (data.flag) {
            case 1:
                $('#zoom-list').html("");
                $(".dropify-preview").css('display', 'none');
                var dato = data.zoom;
                console.log(data);
                $('#zoom_id').val(dato.id);
                $('#name').val(dato.name);
                $('#email').val(dato.email);
                $('#password').val(dato.password);
            
            break;
         
          }
    
    },

    deactivated:function(data) {
        switch (data.flag){
            case 1:
                console.log(data.zoom);
                var dato = data.zoom;
                if(dato.status != 0){
                    if(dato.in_use_by == null){
                        dato.in_use_by = '';
                    }
                    var zoom = `<tr id="zoom_id${dato.id}" >
                                        
                                        <td>${dato.name}</td>
                                        <td>${dato.email}</td>
                                        <td>${dato.password}</td>
                                        <td>${dato.in_use_by}</td>
                                        <td class="hidden-xs">${zooms.status(dato)}</td>
                                        <td>${zooms.button(dato)}</td>
                                    </tr>`;
          
                $("#zoom_id"+dato.id).replaceWith(zoom);
                if(dato.status == 1){
                    color ="#c3e6cb";
                }else if(dato.status == 2){
                    color ="#ed969e";
                }
                $("#zoom_id"+dato.id).css("background-color", color); 

            }else if(dato.status == 0){
                $("#zoom_id"+dato.id).remove();
                swal("Deleted!", data.zoom_deleted, "success")
            }
            break;
           
        }   
    },

    msj: function(data){
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