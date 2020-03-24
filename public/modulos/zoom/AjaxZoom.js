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
    $(document).on('click','#btn_add_user',function(){
        $('#btn-save-user').val("add");
        $('#myModal').modal('show');
        var id = $('.btn_add_user').val();
    });

     //Assign user 
     $("#assignForm").on('submit',function (e) {
        console.log('button');
      
        e.preventDefault(); 
        var formData =  $("#assignForm").serialize();
     
        var type = "PUT"; 
        var my_url = url;
        var state = 'update';
        var id = $('.btn_add_user').val();
        my_url += '/update/' + id;
            console.log(formData);
            actions.edit_create(type,my_url,state,formData);   
         
    });

    //Create Zoom
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

    




});


const zooms ={
    button: function(dato){
           var buttons='';
            if(dato.status== 1){
              
                buttons += ` <button type="button" class="btn btn-sm btn-outline-warning btn_add_user"  title="Assing User"  value="${dato.id}"  ><i class="fa fa-user"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-edit"  title="Edit"  value="${dato.id}"  ><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-type"  title="Deactivated" data-type="confirm" value="${dato.id}"><i class="fa fa-window-close"></i></button>`;
          
           }
           else if(dato.status == 2){
             
            buttons += `<button type="button" class="btn btn-sm btn-outline-secondary btn-edit"  title="Edit"  value="${dato.id}"  ><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-type"  title="Deactivated" data-type="confirm" value="${dato.id}"><i class="fa fa-window-close"></i></button>`;
        }
           return buttons;
    },
    status:function(dato){
        var status='';
        if(dato.status== 1){
            status +="<span class='badge badge-success'>Available</span>";
        }else if(dato.status == 2){
            status +="<span class='badge badge-secondary'>Not Available</span>";
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
                
        }
    },

    
}