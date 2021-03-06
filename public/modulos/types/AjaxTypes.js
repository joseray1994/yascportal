
$(document).ready(function(){
    clearload();
    var nameDeli='<a href="/types">Users Types</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar1').addClass('active') 

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
        $("#myModalLabelType").html('Create User Type <i class="fa fa-address-card"></i>');
        $('#typeUserForm').trigger("reset");
        $('#myModal').modal('show');
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
        console.log('button');
      
        e.preventDefault(); 
        var formData =  $("#typeUserForm").serialize();
        
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var usertype_id = $('#usertype_id').val();;
        var my_url = url;
        if (state == "update"){
            type = "POST"; //for updating existing resource
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
                    title= "Do you want to activated User type?";
                    text="The User Type will be activated";
                    confirmButtonText="Activate";

                    datatitle="Activate";
                    datatext="Activate";
                    datatext2="Activated";
                }
                else 
                {
                    title= "Do you want to deactivated User type?";
                    text= "The User Type will be deactivated";
                    confirmButtonText="Deactivate";

                    datatitle="Deactivate";
                    datatext="deactivate";
                    datatext2="Deactivated";

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
                    swal(datatitle, "User Type "+datatext, "success");
                    actions.deactivated(my_url);
                    } 
                    else {
                    
                    swal("Cancel", datatext2+" cancel", "error");
                
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
            title: "Do you want to remove User type?",
            text: "The User Type will be delete",
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
               swal("Cancel", "Deleting cancelada", "error");
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
const types ={
    button: function(dato){
           var buttons='';
            if(dato.status== 1){
               buttons +='<a class="btn btn-sm btn-outline-primary" title="Assignament Type" id="btn-edit" href="/assignmenttype/'+dato.id+'"  ><i class="fa fa-info-circle"></i></a>'
               buttons += ' <button class="btn btn-sm btn-outline-secondary btn-detail open_modal"  data-toggle="tooltip" title="Edit"  value="'+dato.id+'"> <i class="fa fa-edit"></i></li></button>';
               buttons += '	<button type="button" class="btn btn-sm btn-outline-danger off-type" title="Deactivated" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-window-close"></i></button>';
          
           }else if(dato.status == 2){
               buttons+='<button type="button" class="btn btn-sm btn-outline-success off-type" title="Activated" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-check-square-o"></i></button>'
               buttons += ' <button class="btn btn-outline-danger btn-sm btn-delete delete-profile" data-toggle="tooltip" title="Delete" value="'+dato.id+'"><i class="fa fa-trash-o"></i> </button>';
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

    new_update: function (data,state){
        console.log(data);
        var dato = data;
        var typename =$('#name').val();
        if(data[0]){
            datos = data[0].No;
        }else{
            datos = data;
        }
        switch(datos) {
            case 2:
                $.notify({
                    // options
                    title: "Error!",
                    message:data[0].name,
                },{
                    // settings
                    type: 'danger'
                });
            break;
            default:
                var profile = `<tr id="usertype_id${dato.id}" class="rowType">
                                    <td>${dato.id}</td>
                                    <td>${dato.name}</td>
                                    <td class="hidden-xs">${types.status(dato)}</td>
                                    <td>${types.button(dato)}</td>
                                </tr>`;
            
                if (state == "add"){ 
                $("#usertype-list").append(profile);
                $("#usertype_id"+dato.id).css("background-color", "#c3e6cb");
                $('#table-row').remove(); 
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
            if ($('.rowType').length == 0) {
                var profile = `<tr id="table-row" class="text-center">
                                    <th colspan="7" class="text-center">
                                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                                     </th>
                                </tr>`;

                $("#usertype-list").append(profile);
              }
        }
       
    },

    show: function(data){
        console.log(data);
        $("#myModalLabelType").html('Edit User Type <i class="fa fa-address-card"></i>');
        $('#usertype_id').val(data.id);
        $('#name').val(data.name);
        $('#btn-save').val("update");
        $('#myModal').modal('show');
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



    
