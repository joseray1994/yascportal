//getData(1);

$(document).ready(function(){
    clearload();
    var nameDeli='<a href="/vacancies">Vacancies</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar9').addClass('active');  

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
        $('#vacancyForm').trigger("reset");
        $('#myModal').modal('show');
    });

    
    //display modal form for product EDIT ***************************
    $(document).on('click','.open_modal',function(){
        $('#vacancyForm').trigger("reset");
        var vacancy_id = $(this).val();
        var my_url = url + '/' + vacancy_id;

        actions.show(my_url);
       
    });

    //create new product / update existing product ***************************
    $("#vacancyForm").on('submit',function (e) {
        console.log('button');
      
        e.preventDefault(); 
        var formData =  $("#vacancyForm").serialize();
        
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var vacancy_id = $('#vacancy_id').val();;
        var my_url = url;
        if (state == "update"){
            type = "POST"; //for updating existing resource
            my_url += '/' + vacancy_id;
        }
        
            console.log(formData);
        
            actions.edit_create(type,my_url,state,formData);
    
    });

    $(document).on('click','.off-vacancy',function(){
        var id = $(this).val();
        var my_url =url + '/' + id;
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
            if($(this).attr('class') == 'btn btn-sm btn-outline-success off-vacancy')
            {
                title= "Do you want to activate this Vacancy?";
                text="The vacancy will be activated";
                confirmButtonText="Activate";

                datatitle="Activated";
                datatext="Activated";
                datatext2="Activation";
            }
            else 
            {
                title= "Do you want to deactivate this vacancy?";
                text= "The vacancy will be deactivated";
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
                swal(datatitle, "Vacancy "+datatext, "success");
                actions.deactivated(my_url);
                } 
                else {
                
                swal("Cancelled", datatext2+" cancelled", "error");
            
                }
        });
    });

     //delete product and remove it from TABLE list ***************************
     $(document).on('click','.delete-vacancy',function(){
        var vacancy_id = $(this).val();
        var my_url = url + '/delete/' + vacancy_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Do you want to delete this Vacancy?",
            text: "The vacancy will be permanently eliminated",
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



const vacancies ={
    button: function(dato){
           var buttons='<div class="">';
            if(dato.status== 1){
                buttons += '<a class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="See Candidates" href="/candidates/'+dato.id+'"><i class="fa fa-users"></i></a>';
               buttons += ' <button type="button" class="btn btn-sm btn-outline-secondary open_modal" title="Edit" id="btn-edit" value="'+dato.id+'"  ><i class="fa fa-edit"></i></button>';
               buttons += '	<button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-vacancy" title="Deactivated" data-type="confirm" value="'+dato.id+'"><i class="fa fa-window-close"></i></button>';
          
           }else if(dato.status == 2){
           
               buttons+='<button type="button" class="btn btn-sm btn-outline-success off-vacancy" title="Activated" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-check-square-o"></i></button>'
               buttons += ' <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert delete-vacancy" title="Delete" data-type="confirm" value="'+dato.id+'"><i class="fa fa-trash-o"></i></button>';
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

    nullo:function(dato){
        var description = "";
        if(dato.description != null)
        {
            description = dato.description;
        }

        return description;
    }
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
           
            var vacancy = `<tr id="vacancy_id${dato.id}">
                                <td>${dato.id}</td>
                                <td style="white-space: normal !important; word-wrap: break-word;">${dato.name}</td>
                                <td  style="white-space: normal !important; word-wrap: break-word;">${vacancies.nullo(dato)}</td>
                                <td class="hidden-xs">${vacancies.status(dato)}</td>
                                <td>${vacancies.button(dato)}</td>
                            </tr>`;
        
            if (state == "add"){ 
              $("#vacancy-list").append(vacancy);
              $("#vacancy_id"+dato.id).css("background-color", "#c3e6cb");  
              $('#table-row').remove(); 
            }else{
              $("#vacancy_id"+dato.id).replaceWith(vacancy);
              $("#vacancy_id"+dato.id).css("background-color", "#ffdf7e");  
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
        $('#vacancy_id').val(data.id);
        $('#name').val(data.name);
        $('#description').val(data.description);
        $('#btn-save').val("update");
        $('#myModal').modal('show');
    },

    deactivated:function(data) {
        console.log(data);
        var dato = data;
        if(dato.status != 0){
            var vacancy = `<tr id="vacancy_id${dato.id}">
                                <td>${dato.id}</td>
                                <td style="white-space: normal !important; word-wrap: break-word;">${dato.name}</td>
                                <td  style="white-space: normal !important; word-wrap: break-word;">${vacancies.nullo(dato)}</td>
                                <td class="hidden-xs">${vacancies.status(dato)}</td>
                                <td>${vacancies.button(dato)}</td>
                            </tr>`;
          
            $("#vacancy_id"+dato.id).replaceWith(vacancy);

            if(dato.status == 1){
                color ="#c3e6cb";
            }else if(dato.status == 2){
                color ="#ed969e";
            }
            $("#vacancy_id"+dato.id).css("background-color", color); 


        }else if(dato.status == 0){
            $("#vacancy_id"+dato.id).remove();

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