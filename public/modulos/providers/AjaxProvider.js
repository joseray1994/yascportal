$(document).ready(function(){
    clearload();
    var nameDeli='<a href="/providers">Providers</i></a>';
    $('.nameDeli').html(nameDeli);
   // $('#sidebar9').addClass('active');  

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
        $('#providerForm').trigger("reset");
        $('#myModal').modal('show');
    });

     //display modal form for product EDIT ***************************
     $(document).on('click','.open_modal',function(){
        $('#providerForm').trigger("reset");
        var provider_id = $(this).val();
        var my_url = url + '/' + provider_id;

        actions.show(my_url);
       
    });

      //create new product / update existing product ***************************
      $("#providerForm").on('submit',function (e) {
        console.log('button');
      
        e.preventDefault(); 
        var formData =  $("#providerForm").serialize();
        
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var provider_id = $('#provider_id').val();
        console.log(provider_id );
        var my_url = url;
        if (state == "update"){
            type = "POST"; //for updating existing resource
            my_url += '/' + provider_id;
        }
        
            console.log(formData);
        
            actions.edit_create(type,my_url,state,formData);
    
    });

    $(document).on('click','.off-provider',function(){
        var id = $(this).val();
        var my_url =url + '/' + id;
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
            if($(this).attr('class') == 'btn btn-sm btn-outline-success off-provider')
            {
                title= "Do you want to activate this Provider?";
                text="The provider will be activated";
                confirmButtonText="Activate";

                datatitle="Activated";
                datatext="Activated";
                datatext2="Activation";
            }
            else 
            {
                title= "Do you want to deactivate this provider?";
                text= "The provider will be deactivated";
                confirmButtonText="Deactivate";

                datatitle="disabled";
                datatext="disabled";
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
                swal(datatitle, "Provider "+datatext, "success");
                actions.deactivated(my_url);
                } 
                else {
                
                swal("Cancelled", datatext2+" cancelled", "error");
            
                }
        });
    });


    //delete product and remove it from TABLE list ***************************
    $(document).on('click','.delete-provider',function(){
        var provider_id = $(this).val();
        var my_url = url + '/delete/' + provider_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Do you want to delete this Provider?",
            text: "The provider will be permanently eliminated",
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


const providers ={
    button: function(dato){
           var buttons='<div class="">';
            if(dato.status== 1){
                buttons += '<a class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="See Suppplies"  href="/supplies/'+dato.id+'"><i class="fa fa-cubes"></i></a>';
                buttons += ' <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="'+dato.id+'"  ><i class="fa fa-edit"></i></button>';
                buttons += '	<button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert off-provider" title="Deactivated" data-type="confirm" value="'+dato.id+'"><i class="fa fa-window-close"></i></button>';
          
           }else if(dato.status == 2){
           
               buttons+='<button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-success off-provider" title="Activated" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-check-square-o"></i></button>';
               buttons += '                     <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert delete-provider" title="Delete" data-type="confirm" value="'+dato.id+'"><i class="fa fa-trash-o"></i></button>';
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
        console.log(data);
        if(data[0]){
            var dato = data[0];
        }else{
            var dato = data;
        }
        switch(dato.No) {
            case 2:
                if(data[0].name != ''){
                    $.notify({
                        // options
                        title: "Error!",
                        message:data[0].name,
                    },{
                        // settings
                        type: 'danger'
                    });
                }
                if(data[0].rfc != ''){
                    $.notify({
                        // options
                        title: "Error!",
                        message:data[0].rfc,
                    },{
                        // settings
                        type: 'danger'
                    });
                }
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
            default:

                $.notify({
                    // options
                    title: "Saved!",
                    message:data.name,
                },{
                    // settings
                    type: 'success'
                });
           
            var provider = `<tr id="provider_id${dato.id}">
                                <td>${dato.id}</td>
                                <td>${dato.id_department}</td>
                                <td>${dato.name}</td>
                                <td>${dato.rfc}</td>
                                <td>${dato.phone}</td>
                                <td>${dato.email}</td>
                                <td class="hidden-xs">${providers.status(dato)}</td>
                                <td>${providers.button(dato)}</td>
                            </tr>`;
        
            if (state == "add"){ 
              $("#provider-list").append(provider);
              $("#provider_id"+dato.id).css("background-color", "#c3e6cb");  
              $('#table-row').remove(); 
            }else{
              $("#provider_id"+dato.id).replaceWith(provider);
              $("#provider_id"+dato.id).css("background-color", "#ffdf7e");  
            }

            $('#myModal').modal('hide')

            if ($('.rowType').length == 0) {
                $('#table-row').show();
            }
            break;
            
        }
        
    },

    show: function(data){
        console.log(data);
        $('#provider_id').val(data.id);
        $('#id_department').val(data.id_department);
        $('#name').val(data.name);
        $('#rfc').val(data.rfc);
        $('#phone').val(data.phone);
        $('#email').val(data.email);
        $('#btn-save').val("update");
        $('#myModal').modal('show');
    },

    deactivated:function(data) {
        console.log(data);
        var dato = data;
        if(dato.status != 0){
              var provider = `<tr id="provider_id${dato.id}">
                                <td>${dato.id}</td>
                                <td>${dato.id_department}</td>
                                <td>${dato.name}</td>
                                <td>${dato.rfc}</td>
                                <td>${dato.phone}</td>
                                <td>${dato.email}</td>
                                <td class="hidden-xs">${providers.status(dato)}</td>
                                <td>${providers.button(dato)}</td>
                            </tr>`;
        
          
            $("#provider_id"+dato.id).replaceWith(provider);

            if(dato.status == 1){
                color ="#c3e6cb";
            }else if(dato.status == 2){
                color ="#ed969e";
            }
            $("#provider_id"+dato.id).css("background-color", color); 


        }else if(dato.status == 0){
            $("#provider_id"+dato.id).remove();

            if($("#tag_container tr").length == 1){
                $("#tag_container").append(` <tr id="table-row" class="text-center">
                                                    <th colspan="8" class="text-center">
                                                        <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                                                    </th>
                                                </tr>`);
                                                
            }
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
