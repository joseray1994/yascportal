$(document).ready(function(){

    clearload();

    var nameDeli='<a href="/inventory">Inventory</i></a>';
    $('.nameDeli').html(nameDeli);

    var url = $('#url').val();
    var baseurl = $('#baseurl').val();

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

    //display modal form for product EDIT ***************************
    $(document).on('click','.open_modal',function(){
        $('#inventoryForm').trigger("reset");
        var inventory_id = $(this).val();
        var my_url = url + '/' + inventory_id;

            actions.show(my_url);
       
    });

    //display modal form for product EDIT ***************************
    $(document).on('click','.prov_modal',function(){
        $('#provForm').trigger("reset");
        var inventory_id = $(this).val();
        var my_url = url + '/show/' + inventory_id;

            actions.show(my_url);
       
    });

        //create new product / update existing product ***************************
    $("#btn-save").click(function (e) {
        
        e.preventDefault(); 
        var formData = $("#inventoryForm").serialize();

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var inventory_id = $('#inventory_id').val();
        var my_url = url;

        if (state == "update"){
            type = "POST"; //for updating existing resource
            my_url=url + '/' + inventory_id;
        }
        actions.edit_create(type,my_url,state,formData);
    });

           
        //create new product / update existing product ***************************
        $("#btn-save-prov").click(function (e) {
            
            e.preventDefault(); 
            var formData = $("#provForm").serialize();

            //used to determine the http verb to use [add=POST], [update=PUT]
            var state = $('#btn-save-prov').val();
            var type = "PUT"; //for creating new resource
            var inventory_id = $('#inventory_id').val();
            var my_url = url;

            if (state == "update"){
                type = "PUT"; //for updating existing resource
                my_url=url + '/updateProv/' + inventory_id;
            }
            actions.edit_create(type,my_url,state,formData);
        });

    
    $(document).on('click','.off-inventory',function(){
        var id = $(this).val();
        var my_url =url + '/' + id;
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
            if($(this).attr('class') == 'btn btn-sm btn-outline-success off-inventory')
            {
                title= "Do you want to activate this Inventory?";
                text="The inventory will be activated";
                confirmButtonText="Activate";

                datatitle="Activated";
                datatext="Activated";
                datatext2="Activation";
            }
            else 
            {
                title= "Do you want to disable this inventory?";
                text= "The inventory will be deactivated";
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
                swal(datatitle, "inventory "+datatext, "success");
                actions.deactivated(my_url);
                } 
                else {
                
                swal("Cancelled", datatext2+" Cancelled", "error");
            
                }
        });
    });

    
    //delete product and remove it from TABLE list ***************************
    $(document).on('click','.delete-inventory',function(){
        var inventory_id = $(this).val();
        var my_url = url + '/delete/' + inventory_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Do you want to delete this Inventory?",
            text: "The inventory will be permanently eliminated",
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

const inventories ={
    button: function(dato){
           var buttons='<div class="">';
            if(dato.status== 1){

                buttons += '  <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="'+dato.id+'"  ><i class="fa fa-edit"></i></button>';
                buttons += '  <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert off-inventory" title="Deactivated" data-type="confirm" value="'+dato.id+'"><i class="fa fa-window-close"></i></button>';

          
           }else if(dato.status == 2){
              
               buttons += ' <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-success off-inventory" title="Activated" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-check-square-o"></i></button>';
               buttons += ' <button type="button" data-toggle="tooltip" class="btn btn-sm btn-outline-danger js-sweetalert delete-inventory" title="Delete" data-type="confirm" value="'+dato.id+'"><i class="fa fa-trash-o"></i></button>';

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
           
                var inventory = `<tr id="inventory_id${dato.id}">
                                <td>${dato.id}</td>
                                <td>${dato.id_department}</td>
                                <td>${dato.name_prov}</td>
                                <td>${dato.name}</td>
                                <td>${dato.quantity}</td>
                                <td>${'$'+dato.price.toFixed(2)}</td>
                                <td>${'$'+dato.cost.toFixed(2)}</td>
                                <td>${'$'+dato.total_price.toFixed(2)}</td>
                                <td class="hidden-xs">${inventories.status(dato)}</td>
                                <td>${inventories.button(dato)}</td>
                            </tr>`;

        
            if (state == "add"){ 
              $("#inventory-list").append(inventory);
              $("#inventory_id"+dato.id).css("background-color", "#c3e6cb");  
              $('#table-row').remove(); 
           
            }else{
              $("#inventory_id"+dato.id).replaceWith(inventory);
              $("#inventory_id"+dato.id).css("background-color", "#ffdf7e");  
            }

            $('#myModal').modal('hide')
            $('#myModalProv').modal('hide')

            if ($('.rowType').length == 0) {
                $('#table-row').show();
            }
            break;
            
        }
        
    },

    show: function(data){
        console.log(data);
        switch (data.flag) {
        case 1:
            $('#inventory_id').val(data.inventory.id);
            $('#id_provider').val(data.inventory.id_provider);
            $('#name').val(data.inventory.name);
            $('#quantity').val(data.inventory.quantity);
            $('#price').val(data.inventory.price);
            $('#cost').val(data.inventory.cost);
            $('#total_price').val(data.inventory.total_price);
            $('#btn-save').val("update");
            $('#myModal').modal('show');
        break;
        case 2:
            $('#inventory_id').val(data.inventory.id);
            $('#id_provider2').val(data.inventory.id_provider);
            $('#btn-save').val("update");
            $('#myModalProv').modal('show');
        break;
        }
    },

    deactivated:function(data) {
        console.log(data);
        var dato = data;
        if(dato.status != 0){
            var inventory = `<tr id="inventory_id${dato.id}">
                                <td>${dato.id}</td>
                                <td>${dato.id_department}</td>
                                <td>${dato.name_prov}</td>
                                <td>${dato.name}</td>
                                <td>${dato.quantity}</td>
                                <td>${'$'+dato.price.toFixed(2)}</td>
                                <td>${'$'+dato.cost.toFixed(2)}</td>
                                <td>${'$'+dato.total_price.toFixed(2)}</td>
                                <td class="hidden-xs">${inventories.status(dato)}</td>
                                <td>${inventories.button(dato)}</td>
                            </tr>`;
          
            $("#inventory_id"+dato.id).replaceWith(inventory);

            if(dato.status == 1){
                color ="#c3e6cb";
            }else if(dato.status == 2){
                color ="#ed969e";
            }
            $("#inventory_id"+dato.id).css("background-color", color); 


        }else if(dato.status == 0){
            $("#inventory_id"+dato.id).remove();

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
