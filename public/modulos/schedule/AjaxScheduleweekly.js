
$(document).ready(function(){
    clearload();
    var nameDeli='<a href="/weekly">Schedule Weekly</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar5').addClass('active') 

    //get base URL *********************
    var url = $('#url').val();
    var baseUrl = $('#baseUrl').val();
    $('.js-example-basic-single').select2();
    $('.js-example-basic-multiple').select2();

    //export csv
    $('#csv').on('click',function(){
        date = $('#dateSearch').val();
        client=$('#clientSearch').val();
        operator=$('#operatorSearch').val();
        name =`${date}-${client}-${operator}`
        $("#tag_container").tableHTMLExport({type:'csv',filename:`Weekly${name}.csv`});
      })
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

    $('#dateSearch').change(function(){
        //  $('#daySearch').val(),
        var date = $('#dateSearch').val();
         date = moment(date).format('YYYY/MM/DD');
        var fecha = new Date(date);
        fecha = new Date(fecha.setHours(0,0,0,0));
        var weekday = fecha.getDay();
         $('#daySearch').val(weekday);
         $('#daySearch').trigger('change');
    });

    $('.scheduleWeeklySearch').change(function(){
       
        schedule.get_data(1);
    });

    $('.timeinputsdataExtra').change(function(){
        var formData={
            time_start: $('#time_startE').val(),
            hours:$('#hours').val(),
            minutes:$('#minutes').val(),
            }
        schedule.calculateEnd_time(baseUrl,formData);
    });

    $('.timeinputsdata').change(function(){
        var formData={
            time_start: $('#time_startEx').val(),
            hours:$('#hoursEx').val(),
            minutes:$('#minutesEx').val(),
            }
        schedule.calculateEnd_time(baseUrl,formData);
    });



    //display modal form for product EDIT ***************************
    $(document).on('click','.open_modal',function(){
        $('#typeUserForm').trigger("reset");
        var shcedule_id = $(this).val();
        var my_url = url + '/' + shcedule_id;

            actions.show(my_url);
       
    });
    
    $(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            }else{
                schedule.get_data(page);
            }
        }
    });
    //create new product / update existing product ***************************
    $("#typeUserForm").on('submit',function (e) {
        e.preventDefault(); 
        var formData =  schedule.dataSend();
        
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var shcedule_id = $('#shcedule_id').val();
        var my_url = url;
        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + shcedule_id;
        }
        
            console.log(formData);
        
            actions.edit_create(type,my_url,state,formData);
    
    });

     //create new product / update existing product ***************************
     $("#ExtraForm").on('submit',function (e) {
        e.preventDefault(); 
        var formData = schedule.dataSendEx();
        
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-saveE').val();
        var type = "POST"; //for creating new resource
        var shcedule_id = $('#shcedule_idE').val();;
        var my_url = baseUrl+'/extra';
        if (state == "update"){
            type = "POST"; //for updating existing resource
            my_url += '/' + shcedule_id;
        }
        
            console.log(formData);
        
            actions.edit_create(type,my_url,state,formData);
    
    });

    //delete product and remove it from TABLE list ***************************
    $(document).on('click','.deleteschedule',function(){
        var privada_id = $(this).val();
        var my_url = url + '/' + privada_id;
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
        var shcedule_id = $(this).val();
       
        // Populate Data in Edit Modal Form
        $.ajax({
            type: "GET",
            url: url + '/' + shcedule_id,
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
            if(dato.type== 1){
               buttons +='<a class="btn btn-sm btn-outline-primary" title="Assignament Type" id="btn-edit" href="/assignmenttype/'+dato.id+'"  ><i class="fa fa-info-circle"></i></a>'
               buttons += ' <button class="btn btn-sm btn-secondary btn-detail open_modal"  data-toggle="tooltip" title="Editar nombre del Perfil"  value="'+dato.id+'"> <i class="fa fa-edit"></i></li></button>'
           }else if(dato.type == 2){
                buttons +='<a class="btn btn-sm btn-outline-primary" title="Assignament Type" id="btn-edit" href="/assignmenttype/'+dato.id+'"  ><i class="fa fa-info-circle"></i></a>'
                buttons += ' <button class="btn btn-sm btn-secondary btn-detail open_modal"  data-toggle="tooltip" title="Editar nombre del Perfil"  value="'+dato.id+'"> <i class="fa fa-edit"></i></li></button>';
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
    type:function(dato){
        var status='';
        if(dato.type== 1){
            status +='<span class="badge badge-light">Workday</span>';
        }else if(dato.type == 2){
            status +='<span class="badge badge-dark">Extra</span>';
        }
       return status;
    },
    get_data: function(page){
            var formData={
                day: $('#daySearch').val(),
                client:$('#clientSearch').val(),
                date:$('#dateSearch').val(),
                operator:$('#operatorSearch').val(),
                work:$('#worktypesearch').val(),
            }
            $('.loading-table').show();
            console.log(formData);
            $.ajax(
            {
                url: '?page=' + page,
                data:formData,
                type: "get",
                datatype: "html"
            }).done(function(data){
                $('.pagination').remove();
                $('.loading-table').hide();
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
                time_extra:$('#time_startEx').val(),
                time_endEx:$("#time_endEx").val(),
                hours:$("#hoursEx").val(),
                minutes:$("#minutesEx").val(),
                now:n,
                today:t,
        }
     
        return data;
    },
    dataSendEx: function(){
        var data =  {
                time_start:$('#time_startE').val(),
                time_end:$('#time_endE').val(),
                hours:$("#hours").val(),
                minutes:$("#minutes").val(),
        }
     
        return data;
    },
    selectClient: function(){
        select="";
        $.each(data, function(idx, ope) {
            var select=`<option value="${ope.id}">${ope.name}</option>`;
        });
    }, 
    calculateEnd_time: function(baseUrl,formData){
        console.log(formData);
        $.ajax({
            type:"POST",
            url: baseUrl+'/sumtime',
            data: formData,
            dataType: 'json',
            success: function (data) {
                switch(data.No) {
                    case 1:
                        $.notify({
                            // options
                            title: "Error!",
                            message:data.msg,
                        },{
                            // settings
                            type: 'danger'
                        });
                    break;
                    default:
                      
                        $("#time_endEx").val(data);

                        $("#time_endE").val(data);
                    break;
                }
            },
            error: function (data) {
                console.log('Error:', data);
                
            }
        });

    },
}
const success = {

    new_update: function (data,state){
        console.log(data.No);
        var dato = data;    
        switch(dato.No) {
            case 1:
                    var profile = `<tr id="shcedule_id${dato.wd.detail.id}">
                                    <td>${dato.wd.detail.name} ${dato.wd.detail.lastname}</td>
                                    <td style ="background:${dato.wd.detail.color}">${dato.wd.detail.client}</td>
                                    <td>${dato.wd.detail.day}</td>
                                    <td>${dato.wd.detail.time_s}</td>
                                    <td>${dato.wd.detail.time_e}</td>
                                    <td class="hidden-xs">${schedule.type(dato.wd.detail)}</td>
                                    <td>${schedule.button(dato.wd.detail)}</td>
                                </tr>`;
                    $("#shcedule_id"+dato.wd.detail.id).replaceWith(profile);
                    $("#shcedule_id"+dato.wd.detail.id).css("background-color", "#ffdf7e");
                    $('#myModal2').modal('hide')
            break;
            case 2:
                    var profile = `<tr id="shcedule_id${dato.wd.detail.id}">
                                        <td>${dato.wd.detail.name} ${dato.wd.detail.lastname}</td>
                                        <td style ="background:${dato.wd.detail.color}">${dato.wd.detail.client}</td>
                                        <td>${dato.wd.detail.day}</td>
                                        <td>${dato.wd.detail.time_s}</td>
                                        <td>${dato.wd.detail.time_e}</td>
                                        <td class="hidden-xs">${schedule.type(dato.wd.detail)}</td>
                                        <td>${schedule.button(dato.wd.detail)}</td>
                                    </tr>`;
                    $("#shcedule_id"+dato.wd.detail.id).replaceWith(profile);
                    $("#shcedule_id"+dato.wd.detail.id).css("background-color", "#ffdf7e");
                    
                    if(dato.ed != 0){
                        var profile = `<tr id="shcedule_id${dato.ed.detail.id}">
                                        <td>${dato.ed.detail.name} ${dato.ed.detail.lastname}</td>
                                        <td style ="background:${dato.wd.detail.color}">${dato.ed.detail.client}</td>
                                        <td>${dato.ed.detail.day}</td>
                                        <td>${dato.ed.detail.time_s}</td>
                                        <td>${dato.ed.detail.time_e}</td>
                                        <td class="hidden-xs">${schedule.type(dato.ed.detail)}</td>
                                        <td>${schedule.button(dato.ed.detail)}</td>
                                        </tr>`;
                            $("#shcedule-list").prepend(profile);
                            $("#shcedule_id"+dato.ed.detail.id).css("background-color", "#c3e6cb");    
                    }
                    
                
                    $('#myModal').modal('hide')
            break;
        }
        
        
    },

    deactivated:function(data) {
        console.log(data);
        var dato = data;
        if(dato.status != 0){
            var profile = `<tr id="shcedule_id${dato.id}">
                                <td>${dato.id}</td>
                                <td>${dato.name}</td>
                                <td class="hidden-xs">${types.status(dato)}</td>
                                <td>${types.button(dato)}</td>
                            </tr>`;
          
            $("#shcedule_id"+dato.id).replaceWith(profile);
            if(dato.status == 1){
                color ="#c3e6cb";
            }else if(dato.status == 2){
                color ="#ed969e";
            }
            $("#shcedule_id"+dato.id).css("background-color", color);  
            
        }else if(dato.status == 0){
            $("#shcedule_id"+dato.id).remove();
        }
       
    },

    show: function(data){
        console.log(data);
    
      
        if(data.wd.detail.type == 2){
            $('#btn-saveE').val("update");
            $('#shcedule_idE').val(data.wd.detail.id);
            $('#time_startE').val(data.wd.detail.time_s);
            $('#time_endE').val(data.wd.detail.time_e);
            $('#myModal2').modal('show');
            
        }else{
            $('#btn-save').val("update");
            $('#shcedule_id').val(data.wd.detail.id);
            $('#time_start').val(data.wd.detail.time_s);
            $('#time_end').val(data.wd.detail.time_e);
    
            if(data.wd.days.length == 0){
                $('#days').val(null);
                $('#days').trigger('change');
            }else{
    
                $('#days').val(data.wd.days)
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



    
