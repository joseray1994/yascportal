
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
      });
      
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
    });

    $('.scheduleWeeklySearch').bind("keyup change",function(){
        schedule.get_data(1);
    });
    $('.AuditSearch').bind("keyup change",function(){
        var my_url= baseUrl + '/detail/' +  $('#auditid').val();
        schedule.get_data_audit(my_url);
    });

    $('.timeinputsdataExtra').bind("keyup change",function(){
        var formData={
            time_start: $('#time_startE').val(),
            hours:$('#hours').val(),
            minutes:$('#minutes').val(),
            }
        schedule.calculateEnd_time(baseUrl,formData);
    });

    $('.timeinputsdata').bind("keyup change", function(){
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
        var action = $(this).children("#tokenSch"+shcedule_id).val();
        var url= baseUrl + '/detail/' + shcedule_id;
        actions.modal(url,action);
        });
    $('.back-weekly').click(function(){
        $('#auditid').val("");
        $('#audit-table').html("");
        $('.view-audit').hide();
        $('.view-suspended').hide(); 
        $('.view-index').show();
        
    });

    $(document).on('click','.quitschedule',function(){
        var privada_id = $(this).val();
        var my_url = baseUrl + '/quit/' + privada_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Do you want to cancel this all schedules for this user?",
            text: "All hours for this user will be canceled",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Quit",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {
                actions.deactivated(my_url);
            }else {
               swal("Canceled", "Deletion canceled", "error");
            }
          });
        });


    $(document).on('click','.endShifSchedule',function(){
                var privada_id = $(this).val();
                var my_url = baseUrl + '/endshift/' + privada_id;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                swal({
                    title: "Do you want to end shift for this user?",
                    text: "Shift for this user will be ending",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "End Shift",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                    closeOnCancel: false
                  },
                  function(isConfirm) {
                    if (isConfirm) {
                        actions.deactivated(my_url);
                    }else {
                       swal("Canceled", "End Shift canceled", "error");
                    }
                  });
        });


    $(document).on('click','.open_modal_suspended',function(){
            $('#SuspendedForm').trigger("reset");
            var shcedule_id = $(this).val();
            var my_url = baseUrl + '/suspended/' + shcedule_id;
    
                actions.show(my_url);
    });

    
    $(document).on('click','#btn_add_suspended',function(){
        $('#SuspendedForm').trigger("reset");
        $('#btn-saveS').val('add');
         $('#myModaSuspended').modal('show');
    });   
   
    //create new product / update existing product ***************************
    $("#SuspendedForm").on('submit',function (e) {
            e.preventDefault(); 
            var formData = {
                operator:$('#user_suspended').val(),
                date_start:$("#date_startS").val(),
                date_end:$("#date_EndS").val(),
            };
            
            //used to determine the http verb to use [add=POST], [update=PUT]
            var state = $('#btn-saveS').val();
            var type = "POST"; //for creating new resource
            var shcedule_id = $('#shcedule_idS').val();
            var my_url = baseUrl+'/suspended';
            if (state == "update"){
                type = "PUT"; //for updating existing resource
                my_url += '/' + shcedule_id;
            }
            
                console.log(formData);
            
                actions.edit_create(type,my_url,state,formData);
        
    });
    
    $(document).on('click','.off-suspended',function(){
        var id = $(this).val();
        var my_url =baseUrl + '/suspended/' + id;
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
            if($(this).attr('class') == 'btn btn-sm btn-outline-success off-suspended')
            {
                title= "Do you want to activate this suspension?";
                text="The suspension will be activated";
                confirmButtonText="Activated";

                datatitle="Activated";
                datatext="Activated";
            }
            else 
            {
                title= "Do you want to deactivate this suspension?";
                text= "The suspension will be deactivated";
                confirmButtonText="Deactivated";

                datatitle="Deactivated";
                datatext="Deactivated";

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
                swal(datatitle, "Suspension "+datatext, "success");
                actions.deactivated(my_url);
                } 
                else {
                
                swal("Cancelled", datatext+" cancelled", "error");
            
                }
        });
    });

//delete product and remove it from TABLE list ***************************
$(document).on('click','.delete-profile',function(){
    var privada_id = $(this).val();
    var my_url = baseUrl + '/suspended/delete/' + privada_id;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    swal({
        title: "Do you want to delete suspension?",
        text: "The suspension will be permanently removed",
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
           swal("Cancelled", "Deletion canceled", "error");
        }
      });
    });
      
    
$(document).on('click','.open_modal_audit',function(){

        $('#SuspendedForm').trigger("reset");
        var shcedule_id = $(this).val();
        var my_url = baseUrl + '/auditdetail/' + shcedule_id;
        actions.show(my_url);
      
});

$(document).on('click','.cancel_data_detail',function(){
        $("#option-old").val('');
        $("#select-option-old").hide();
        $("#option-news").val('');
        $("#select-option-news").hide();
   
});

    
});
const schedule ={
    button: function(dato){
           var buttons='';
            if(dato.type== 1){
               buttons +='<button type="button" class="btn btn-sm btn-outline-primary open_detail" data-toggle="tooltip" title="Edit" id="btn-edit" value="'+dato.id+'"  ><i class="fa fa-info-circle"></i></button>'
               buttons += ' <button class="btn btn-sm btn-secondary btn-detail open_modal"  data-toggle="tooltip" title="Editar nombre del Perfil"  value="'+dato.id+'"> <i class="fa fa-edit"></i></li></button>'
           }else if(dato.type == 4){
                buttons +='<button type="button" class="btn btn-sm btn-outline-primary open_detail" data-toggle="tooltip" title="Edit" id="btn-edit" value="{{$type->id}}"  ><i class="fa fa-info-circle"></i></button>'
                buttons += ' <button class="btn btn-sm btn-secondary btn-detail open_modal"  data-toggle="tooltip" title="Editar nombre del Perfil"  value="'+dato.id+'"> <i class="fa fa-edit"></i></li></button>';
                buttons += '<button class="btn btn-danger btn-sm btn-delete delete-profile" data-toggle="tooltip" title="Desactivar Perfil" value="'+dato.id+'"><i class="fa fa-trash-o"></i> </button>';
           }
           return buttons;
    },
    status:function(dato){
        var status='';
        if(dato.status== 1){
            status +='<span class="badge badge-pill badge-success">Day on</span>';
        }else if(dato.status == 2){
            status +='<span class="badge badge-pill badge-secondary">Day off</span>';
        }
       return status;
    },
    type:function(dato){
        var status='';
        if(dato.type== 1){
            status +='<span class="badge badge-light">Workday</span>';
        }else if(dato.type == 4){
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
    get_data_audit: function(my_url){
            var formData={
                date: $('#dateSearchaudit').val(),
                time:$('#timeSearchaudit').val(),
                action:$("#da").val(),
            }
            console.log(formData);
            $.ajax(
            {  url:my_url,
                data:formData,
                type: "get",
            }).done(function(data){
                success.modal(data);  
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
                $.notifyClose();
                $.each(data.responseJSON.errors,function (k,message) {
                    $.notify({
                        // options
                        title: "Error!",
                        message:message,
                    },{
                        // settings
                        type: 'warning'
                    });
                });
                
            }
        });

    },
}

const suspendedValue ={
    status:function (dato){
        var status='';
        if(dato.status== 1){
            status +='<span class="badge badge-pill badge-success">On</span>';
        }else if(dato.status == 2){
            status +='<span class="badge badge-pill badge-secondary">Off</span>';
        }
       return status;

        },
    button: function(dato){
                var buttons='';
                    if(dato.status== 1){
                    buttons += ' <button class="btn btn-sm btn-outline-secondary btn-detail open_modal_suspended"  data-toggle="tooltip" title="Editar nombre del Perfil"  value="'+dato.id+'"> <i class="fa fa-edit"></i></li></button>';
                    buttons += '	<button type="button" class="btn btn-sm btn-outline-danger off-suspended" title="Desactivar Usuario" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-window-close"></i></button>';
                
                }else if(dato.status == 2){
                    buttons+='<button type="button" class="btn btn-sm btn-outline-success off-suspended" title="Activar Usuario" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-check-square-o"></i></button>'
                    buttons += '<button class="btn btn-danger btn-sm btn-delete delete-profile" data-toggle="tooltip" title="Desactivar Perfil" value="'+dato.id+'"><i class="fa fa-trash-o"></i> </button>';
                }
                return buttons;
            },
}

const audit = {

    button: function(dato){
        var buttons='';
            buttons += '<button class="btn btn-sm btn-outline-secondary btn-detail open_modal_audit"  data-toggle="tooltip" title="Detail Audit"  value="'+dato.id+'"> <i class="fa fa-info"></i></li></button>'; 
        return buttons;
    },
    dataresultaudit: function(data){
                old = JSON.parse(data.audit.old);
                news = JSON.parse(data.audit.new);
                var datosold="";
                var datosnews="";

                    if(old.time_start){
                        datosold+=`<li class="list-group-item">Time Start: ${old.time_start}</li>`;
                    }
                    if(old.time_end){
                        datosold+=`<li class="list-group-item">Time Start: ${old.time_end}</li>`;
                    }
                    if(old.status){
                        switch(old.status) {
                            case 1:
                              datosold+=`<li class="list-group-item">Status: Day ON</li>`;
                              break;
                            case 2:
                              datosold+=`<li class="list-group-item">Status: Day Off</li>`;
                              break;
                            case 3:
                              datosold+=`<li class="list-group-item">Status: Quit</li>`;
                              break;
                            case 0:
                                datosold+=`<li class="list-group-item">Status: Remove</li>`;
                            break;
                          }
                        
                    }

                    if(old.option){
                        $("#option-old").val(old.option);
                        $("#select-option-old").show();
                    }

                    if(news.time_start){
                        datosnews+=`<li class="list-group-item">Time Start: ${news.time_start}</li>`;
                    }
                    if(news.time_end){
                        datosnews+=`<li class="list-group-item">Time Start: ${news.time_end}</li>`;
                    }
                    if(news.status){
                        switch(news.status) {
                            case 1:
                              datosnews+=`<li class="list-group-item">Status: Day ON</li>`;
                              break;
                            case 2:
                              datosnews+=`<li class="list-group-item">Status: Day Off</li>`;
                              break;
                            case 3:
                              datosnews+=`<li class="list-group-item">Status: Quit</li>`;
                            break;
                            case 0:
                                datosnews+=`<li class="list-group-item">Status: Remove</li>`;
                            break;
                          }
                        
                    }
                    if(news.option){
                        $("#option-news").val(news.option);
                        $("#select-option-news").show();
                    }
            data={
                old:datosold,
                news:datosnews,
            }
        
        return data;

    }
}
const success = {

    new_update: function (data,state){
        console.log(data);
        var dato = data;    
        switch(dato.No) {
            case 1:
                    var profile = `<tr id="shcedule_id${dato.ed.detail.id}">
                                    <td>${dato.ed.detail.name} ${dato.ed.detail.lastname}</td>
                                    <td style ="background:${dato.ed.detail.color}">${dato.ed.detail.client}</td>
                                    <td>${dato.ed.detail.day}</td>
                                    <td>${dato.ed.detail.time_s}</td>
                                    <td>${dato.ed.detail.time_e}</td>
                                    <td class="hidden-xs">${schedule.status(dato.ed.detail)}</td>
                                    <td class="hidden-xs">${schedule.type(dato.ed.detail)}</td>
                                    <td >${schedule.button(dato.ed.detail)}</td>
                                </tr>`;
                    $("#shcedule_id"+dato.ed.detail.id).replaceWith(profile);
                    $("#shcedule_id"+dato.ed.detail.id).css("background-color", "#ffdf7e");
                    $('#myModal2').modal('hide')
            break;
            case 2:
                    if($('#daySearch').val() =="allDays"){
                        schedule.get_data(1);
                    }else{
                        var profile = `<tr id="shcedule_id${dato.wd.detail.id}">
                                            <td>${dato.wd.detail.name} ${dato.wd.detail.lastname}</td>
                                            <td style ="background:${dato.wd.detail.color}">${dato.wd.detail.client}</td>
                                            <td>${dato.wd.detail.day}</td>
                                            <td>${dato.wd.detail.time_s}</td>
                                            <td>${dato.wd.detail.time_e}</td>
                                            <td class="hidden-xs">${schedule.status(dato.wd.detail)}</td>
                                            <td class="hidden-xs">${schedule.type(dato.wd.detail)}</td>
                                            <td >${schedule.button(dato.wd.detail)}</td>
                                        </tr>`;

                        $("#shcedule_id"+dato.wd.detail.id).replaceWith(profile);
                        $("#shcedule_id"+dato.wd.detail.id).css("background-color", "#ffdf7e");
                        
                        if(dato.ed != 0){
                            var profile = `<tr id="shcedule_id${dato.ed.detail.id}">
                                            <td>${dato.ed.detail.name} ${dato.ed.detail.lastname}</td>
                                            <td style ="background:${dato.ed.detail.color}">${dato.ed.detail.client}</td>
                                            <td>${dato.ed.detail.day}</td>
                                            <td>${dato.ed.detail.time_s}</td>
                                            <td>${dato.ed.detail.time_e}</td>
                                            <td class="hidden-xs">${schedule.status(dato.ed.detail)}</td>
                                            <td class="hidden-xs">${schedule.type(dato.ed.detail)}</td>
                                            <td >${schedule.button(dato.ed.detail)}</td>
                                            </tr>`;
                                $("#shcedule-list").prepend(profile);
                                $("#shcedule_id"+dato.ed.detail.id).css("background-color", "#c3e6cb");    
                        }
    
                    }
                    $('#myModal').modal('hide')
            break;
            case 3:
                $.notifyClose();
                    $.notify({
                        // options
                        title: "Error!",
                        message:data.msg,
                    },{
                        // settings
                        type: 'danger'
                    });
            break;
            case 4:
                    var res = `<tr id="suspended${dato.suspended.id}" class="dayofftd">
                                <td>${dato.suspended.name}${dato.suspended.lname}</td>
                                <td>
                                    ${dato.suspended.dateS}
                                </td>
                                <td>
                                    ${dato.suspended.dateE} 
                                </td>
                                <td >${suspendedValue.status(dato.suspended)}</td>
                                <td >${suspendedValue.button(dato.suspended)}</td>
                            </tr>`;

                    if(state == 'add'){
                        $("#supended-table").append(res);
                        $("#suspended"+dato.suspended.id).css("background-color", "#c3e6cb");
                        $('#off-suspend').remove(); 
                    }else{
                        $("#suspended"+dato.suspended.id).replaceWith(res);
                        $("#suspended"+dato.suspended.id).css("background-color", "#ffdf7e");
                    }
                    
                        $('#myModaSuspended').modal('hide');
            break;
        }
       
    },

    deactivated:function(data) {
        console.log(data);
        switch(data.No) {
            case 1:
                var dato = data;
                if(dato.wd.status > 0){

                    schedule.get_data(1);

                }else if(dato.wd.status == 0){
                    $("#shcedule_id"+dato.wd.id).remove();
                }
            break;
            case 2:
                var dato = data;
                if(dato.suspended.status > 0){

                    var res = `<tr id="suspended${dato.suspended.id}" class="dayofftd">
                                    <td>${dato.suspended.name}${dato.suspended.lname}</td>
                                    <td>
                                        ${dato.suspended.dateS}
                                    </td>
                                    <td>
                                        ${dato.suspended.dateE} 
                                    </td>
                                    <td >${suspendedValue.status(dato.suspended)}</td>
                                    <td >${suspendedValue.button(dato.suspended)}</td>
                                </tr>`;

                    $("#suspended"+dato.suspended.id).replaceWith(res);
                    if(dato.suspended.status == 1){
                        color ="#c3e6cb";
                    }else if(dato.suspended.status == 2){
                        color ="#ed969e";
                    }
                    $("#suspended"+dato.suspended.id).css("background-color", color);  

                }else if(dato.suspended.status == 0){
                    $("#suspended"+dato.suspended.id).remove();
                }
            break;
        }
       
    },

    show: function(data){
        console.log(data);
        switch(data.No) {
            case 1:
                if(data.wd.detail.type == 4){
                    $('#btn-saveE').val("update");
                    $('#shcedule_idE').val(data.wd.detail.id);
                    $('#time_startE').val(data.wd.detail.time_s);
                    $('#time_endE').val(data.wd.detail.time_e);
                    $("#hours").val(data.wd.detail.hours);
                    $("#minutes").val(data.wd.detail.minutes);
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
            break;
            case 2:
              
                    $("#date_startS").val(data.suspended.dateS);
                    $("#date_EndS").val(data.suspended.dateE);
                    $('#btn-saveS').val('update');
                    $('#shcedule_idS').val(data.suspended.id);
                    $('#myModaSuspended').modal('show');
            break;
            case 3:
                    da=audit.dataresultaudit(data);
                    $("#new_values").html(da.news);
                    $("#old_values").html(da.old);

                    $("#myModaAudit").modal('show');
            break;
        }
        
    },
    modal: function(data){
        console.log(data);
       
        switch(data.No) {
            case 1:
                dato="";
                if(data.suspended.length > 0) {
                    $("#off-row").remove();

                    
                    $.each(data.suspended, function (index, da) {
                     
                        var dato2 = `<tr id="suspended${da.id}" class="dayofftd">
                                        <td>${da.name}${da.lname}</td>
                                        <td>
                                            ${da.dateS}
                                        </td>
                                        <td>
                                            ${da.dateE} 
                                        </td>
                                        <td >${suspendedValue.status(da)}</td>
                                        <td >${suspendedValue.button(da)}</td>
                                    </tr>`;
                    dato += dato2;
                    });
                }else{
                    dato += `<tr id="off-suspend" class="text-center">
                                    <th colspan="5" class="text-center no-data">
                                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                                    </th>
                                </tr>`;

                } 
                $('#user_suspended').val(data.operator),
                $("#da").val(1);
                $('#supended-table').html(dato);
                $('.view-index').hide();
                $('.view-audit').hide();
                $('.view-suspended').show(); 
            break;
            case 2:
                dato="";
                if(data.audit[0]){
                    $('#auditid').val(data.audit[0].id);
                }
               
                if(data.audit.length > 0) {
                    $("#off-row").remove();
                    $.each(data.audit, function (index, da) {

                        var dato2 = `<tr class="dayofftd">
                                        <td>${da.name}${da.lname}</td>
                                        <td >${da.event}</td>
                                        <td >${da.created}</td>
                                        <td >${audit.button(da)}</td>
                                    </tr>`;
                    dato += dato2;
                    });
                }else{
                    dato += `<tr id="off-row" class="text-center">
                                    <th colspan="4" class="text-center no-data">
                                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                                    </th>
                                </tr>`;

                }  

                $('#audit-table').html(dato);
                $("#da").val(2);
                $('.view-index').hide();
                $('.view-suspended').hide();
                $('.view-audit').show(); 
            break;
           
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



    
