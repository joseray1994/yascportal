$(document).ready(function(){

    clearload();

    var prov0 = $('#id_provider').val();

    var nameDeli='<a href="/providers">Providers</i></a> / <a href="/supplies/'+prov0+'">Supplies</i></a>';
    $('.nameDeli').html(nameDeli); 

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
        $('#supplyForm').trigger("reset");
        $('#myModal').modal('show');
    });

    
    $('.btn-cancel').click(function(){
        $('#btn-save').val("add");
        $('#supplyForm').trigger("reset");
        $('#myModal').modal('hide');
    });

        //display modal form for product EDIT ***************************
        $(document).on('click','.open_modal',function(){
            $('#supplyForm').trigger("reset");
            var supply_id = $(this).val();
            var my_url = url + '/' + supply_id;
    
                actions.show(my_url);
           
        });

      
    
         //create new product / update existing product ***************************
         $("#supplyForm").on('submit',function (e) {
            console.log('button');
          
            e.preventDefault(); 
            var formData =  $("#supplyForm").serialize();
        
    
            //used to determine the http verb to use [add=POST], [update=PUT]
            var state = $('#btn-save').val();
            var type = "POST"; //for creating new resource
            var supply_id = $('#supply_id').val();
            var my_url = url;
            if (state == "update"){
                type = "POST"; //for updating existing resource
                my_url += '/' + supply_id;
            }
            
                console.log(formData);
            
                actions.edit_create(type,my_url,state,formData);
        
        });

    $(document).on('click','.off-supply',function(){
        var id = $(this).val();
        var my_url =url + '/' + id;
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
            if($(this).attr('class') == 'btn btn-sm btn-outline-success off-supply')
            {
                title= "Do you want to activate this Supply?";
                text="The supply will be activated";
                confirmButtonText="Activate";

                datatitle="Activated";
                datatext="Activated";
                datatext2="Activation";
            }
            else 
            {
                title= "Do you want to disable this supply?";
                text= "The supply will be deactivated";
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
                swal(datatitle, "supply "+datatext, "success");
                actions.deactivated(my_url);
                } 
                else {
                
                swal("Cancelled", datatext2+" Cancelled", "error");
            
                }
        });
    });


       
         //delete product and remove it from TABLE list ***************************
         $(document).on('click','.delete-supply',function(){
            var supply_id = $(this).val();
            var my_url = url + '/delete/' + supply_id;
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            swal({
                title: "Do you want to delete this Supply?",
                text: "The supply will be permanently eliminated",
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

             
        //total
        $(".add-price").on("keyup", function() {
            price = $('#price').val();
            quantity = $('#quantity').val();

            total =  parseFloat(price) * parseFloat(quantity);
            
            $('#total_price').val(total);
            
        });
});



const supplies ={
    button: function(dato){
           var buttons='<div class="">';
            if(dato.status== 1){

                buttons += ' <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="'+dato.id+'"  ><i class="fa fa-edit"></i></button>';
                buttons += ' <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert off-supply" title="Deactivated" data-type="confirm" value="'+dato.id+'"><i class="fa fa-window-close"></i></button>';

          
           }else if(dato.status == 2){
              
               buttons += '  <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-success off-supply" title="Activated" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-check-square-o"></i></button>';
               buttons += ' <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert delete-supply" title="Delete" data-type="confirm" value="'+dato.id+'"><i class="fa fa-trash-o"></i></button>';

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
        var dato = data;
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

                $.notify({
                    // options
                    title: "Saved!",
                    message:data.name,
                },{
                    // settings
                    type: 'success'
                });
           
                var supply = `<tr id="supply_id${dato.id}">
                                    <td>${dato.id}</td>
                                    <td>${dato.id_department}</td>
                                    <td>${dato.name_prov}</td>
                                    <td>${dato.name}</td>
                                    <td>${dato.quantity}</td>
                                    <td>${'$'+dato.price.toFixed(2)}</td>
                                    <td>${'$'+dato.cost.toFixed(2)}</td>
                                    <td>${'$'+dato.total_price.toFixed(2)}</td>
                                    <td class="hidden-xs">${supplies.status(dato)}</td>
                                    <td>${supplies.button(dato)}</td>
                            </tr>`;

        
                            if (state == "add"){ 
                                $("#supply-list").append(supply);
                                $("#supply_id"+dato.id).css("background-color", "#c3e6cb");  
                                $('#table-row').remove(); 
                              }else{
                                $("#supply_id"+dato.id).replaceWith(supply);
                                $("#supply_id"+dato.id).css("background-color", "#ffdf7e");  
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
        $('#supply_id').val(data.id);
        $('#id_provider').val(data.id_provider);
        $('#id_department').val(data.id_department);
        $('#name').val(data.name);
        $('#quantity').val(data.quantity);
        $('#price').val(data.price);
        $('#cost').val(data.cost);
        $('#total_price').val(data.total_price);
        $('#btn-save').val("update");
        $('#myModal').modal('show');
    },


    deactivated:function(data) {
        console.log(data);
        var dato = data;
        if(dato.status != 0){
            var supply = `<tr id="supply_id${dato.id}">
                                <td>${dato.id}</td>
                                <td>${dato.id_department}</td>
                                <td>${dato.name_prov}</td>
                                <td>${dato.name}</td>
                                <td>${dato.quantity}</td>
                                <td>${'$'+dato.price.toFixed(2)}</td>
                                <td>${'$'+dato.cost.toFixed(2)}</td>
                                <td>${'$'+dato.total_price.toFixed(2)}</td>
                                <td class="hidden-xs">${supplies.status(dato)}</td>
                                <td>${supplies.button(dato)}</td>
                            </tr>`;
          
            $("#supply_id"+dato.id).replaceWith(supply);

            if(dato.status == 1){
                color ="#c3e6cb";
            }else if(dato.status == 2){
                color ="#ed969e";
            }
            $("#supply_id"+dato.id).css("background-color", color); 


        }else if(dato.status == 0){
            $("#supply_id"+dato.id).remove();

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