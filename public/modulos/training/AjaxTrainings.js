getData(1);

$(document).ready(function(){
    
    var nameDeli='<a href="/training">Training</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar10').addClass('active');  

    //get base URL *********************
    var url = $('#url').val();
    var baseUrl = $('#baseUrl').val();
     $('.js-example-basic-single').select2();
    $('.js-example-basic-multiple').select2();


    //display modal form for creating new product *********************
    $('#btn_add').click(function(){
        $('#myModalLabel').html(`Create New Trainee `);
        $('#btn-save').val("add");
        $('#formTraining').show();
        $("#btn_add").hide();
        $('#btn-save').val("add");
        $('#id_client').val("");
        $('#id_client').trigger('change');
        $('#traineeNewForm').trigger("reset");
        $(".bodyIndex").hide();
        $("#flag").val(false);
        $(".seccion-sugerencia").hide();
        $(".segunda-seccion").hide();
        $("#nickname").attr('disabled', true);
        $(".btnGenerate").show();
        $('#id_trainer').val("");
        $('#id_trainer').trigger('change');
    });
       //display cancel modal form for creating new product *********************
    $('.btn-cancel').click(function(){
        $('#myModalLabel').html(`Create New Trainee`);
        $('#formTraining').hide();
        $(".bodyIndex").show();
        $('#traineeNewForm').trigger("reset");
        $('#btn-save').val("add");
        $(".seccion-sugerencia").hide();
        $("#btn_add").show();
        $('#id_client').val("");
        $('#id_client').trigger('change');
        $('#id_trainer').val("");
        $('#id_trainer').trigger('change');
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


        training.get_data(1);
    });

    $('.trainingSearch').change(function(){
        training.get_data(1);
    });

    //function to change the schedule every day by selecting start_Sunday
    $('#start_sunday').change(function(){
        var start_sunday = $('#start_sunday').val();
        $('#start_monday').val(start_sunday);
        $('#start_monday').trigger('change');
        $('#start_tuesday').val(start_sunday);
        $('#start_tuesday').trigger('change');
        $('#start_wednesday').val(start_sunday);
        $('#start_wednesday').trigger('change');
        $('#start_thursday').val(start_sunday);
        $('#start_thursday').trigger('change');
        $('#start_friday').val(start_sunday);
        $('#start_friday').trigger('change');
        $('#start_saturday').val(start_sunday);
        $('#start_saturday').trigger('change');
    });

     //function to change the schedule every day by selecting end_Sunday
     $('#end_sunday').change(function(){
        var end_sunday = $('#end_sunday').val();
        $('#end_monday').val(end_sunday);
        $('#end_monday').trigger('change');
        $('#end_tuesday').val(end_sunday);
        $('#end_tuesday').trigger('change');
        $('#end_wednesday').val(end_sunday);
        $('#end_wednesday').trigger('change');
        $('#end_thursday').val(end_sunday);
        $('#end_thursday').trigger('change');
        $('#end_friday').val(end_sunday);
        $('#end_friday').trigger('change');
        $('#end_saturday').val(end_sunday);
        $('#end_saturday').trigger('change');
    });

    //function to calculate the date with the number of weeks for training
    $('.n_weeks_training').change(function(){
        var numWeek = $('#numWeek').val();
        var numWeek2 = $('#numWeek2').val();
        var start_training=$('#start_training').val();
        var end_training=$('#end_training').val();
        
        training.get_weeks_T(numWeek,start_training,end_training);
    });

    $('#numWeek').keyup(function(){
        var numWeek = $('#numWeek').val();
        var numWeek2 = $('#numWeek2').val();
        var start_training=$('#start_training').val();
        var end_training=$('#end_training').val();
        if (numWeek>0) {
            training.get_weeks_T(numWeek,start_training,end_training);
            
        }
        $('#flag').val(0);
    });

    $('.n_weeks_coaching').change(function(){
        var numWeek_C = $('#numWeek_C').val();
        var numWeek_C2 = $('#numWeek_C2').val();
        var end_training=$('#end_training').val();
        var end_coaching=$('#end_coaching').val();
        
        training.get_weeks_C(numWeek_C,end_training,end_coaching);
    });


    //display modal form for product EDIT ***************************
    $(document).on('click','.open_modal',function(){
        $('#traineeNewForm').trigger("reset");
        var training_id = $(this).val();
        var my_url = url + '/' + training_id;

            actions.show(my_url);
       
    });



    //create new product / update existing product ***************************
    $("#traineeNewForm").on('submit',function (e) {
        console.log('button');
      
        e.preventDefault(); 
        $('#btn-save').attr('disabled', true);
        var formData =  $("#traineeNewForm").serialize();

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var training_id = $('#training_id').val();;
        var my_url = url;
        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + training_id;
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
                    title= "Do you want to activate this Trainee?";
                    text="The User and Schedule will be activated";
                    confirmButtonText="Activate";

                    datatitle="Activated";
                    datatext="activated";
                    datatext2="Activation";
                }
                else 
                {
                    title= "Do you want to disable this Trainee?";
                    text= "The User and Schedule will be deactivated";
                    confirmButtonText="Desactivar";

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
                    swal(datatitle, "Trainee "+datatext, "success");
                    actions.deactivated(my_url);
                    } 
                    else {
                    
                    swal("Cancelled", datatext2+" cancelled", "error");
                
                    }
            });
        });

    //delete product and remove it from TABLE list ***************************
    $(document).on('click','.deleteTraining',function(){
        var privada_id = $(this).val();
        var my_url = url + '/delete/' + privada_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Are you sure you wish to delete this Trainee?",
            text: "All the information of this apprentice will be eliminated",
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


    //display modal form for product DETAIL ***************************
    $(document).on('click','.open_detail',function(){
        var training_id = $(this).val();
       
        // Populate Data in Edit Modal Form
        $.ajax({
            type: "GET",
            url: url + '/' + training_id,
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

    $("#btn-nick-generate").click(function(e){
        e.preventDefault();

        var name = $("#name").val();
        var last_name = $("#last_name").val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            type:"POST",
            url:baseUrl+'/generate',
            data:{name:name, last_name:last_name},
            dataType:"json",
            success: function(data){
                var html = "";
                $.notifyClose();
                if(data.No){
                    $.notify({
                        // options
                        title: "Error!",
                        message:data.msg,
                    },{
                        // settings
                        type: 'danger'
                    });
                }else{
                    html += `<option value="">Seleccionar</option> `;
                    html += `<option value="0">None</option> `;
                    data.forEach(function(data){
                        html += `<option value="${data}">${data}</option> `;
                    });
                    $("#sugerencias").html(html);
                    $(".seccion-sugerencia").show();
                }
            },
            error: function(err){
                $(".seccion-sugerencia").hide();
                console.log(err);
            }
        });
    });

    $("#sugerencias").change(function(){
        valor = $(this).val();
        flag = $("#flag").val();
        if(valor != 0 || valor != ""){

            if(flag === "false"){

                if(valor == 0){
                    valor = "";
                }
                $("#nickname").val(valor);
                $("#nickname").attr('disabled', false);
                $("#email").val(valor+'@yascemail.com');
                $("#email2").val(valor+'@yascemail.com');
                $("#password").val(valor + "*2020");
                $("#password2").val(valor + "*2020");
                $("#password_confirmation").val(valor + "*2020");
                $(".segunda-seccion").show();
            }
        }else{
            $(".segunda-seccion").hide();
            $("#nickname").val("");
            $("#email").val("");
            $("#email2").val("");
            $("#password").val("");
            $("#password2").val("");
            $("#password_confirmation").val("");
        }
    });

    $("#nickname").keyup(function(){

        flag = $("#flag").val();

        if(flag === "false"){
            nickname = $(this).val();
            nickname = nickname.toLowerCase();
            if(nickname != ""){
                $("#email").val(nickname+'@yascemail.com');
                $("#email2").val(nickname+'@yascemail.com');
                $("#password").val(nickname + "*2020");
                $("#password2").val(nickname + "*2020");
                $("#password_confirmation").val(nickname + "*2020");
            }else{
                $("#nickname").val("");
                $("#email").val('@yascemail.com');
                $("#email2").val('@yascemail.com');
                $("#password").val("*2020");
                $("#password2").val("*2020");
                $("#password_confirmation").val("*2020");
            }
        }

    });

    $("#name, #last_name").keyup(function(){
        flag = $("#flag").val();
        if(flag === "false"){

            $("#nickname").val("");
            $(".seccion-sugerencia").hide();
            $(".segunda-seccion").hide();
            $("#nickname").attr('disabled', true);
        }
    });
    
});

const training ={
    button: function(dato){
           var buttons='';
            if(dato.status_user== 1 || dato.status_user== "1"){
               buttons += ' <button class="btn  btn-sm btn-outline-secondary open_modal"  data-toggle="tooltip" title="Edit"  value="'+dato.id_user+'"> <i class="fa fa-edit"></i></li></button>';
               buttons += '	<button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-type" title="Disable User and Schedule" data-type="confirm" value="'+dato.id_user+'" ><i class="fa fa-window-close"></i></button>';
          
           }else if(dato.status_user== 2 || dato.status_user== "2"){
               buttons+='<button type="button" class="btn btn-sm btn-outline-success off-type" title="Activated" data-type="confirm" value="'+dato.id_user+'" ><i class="fa fa-check-square-o"></i></button>'
               buttons += '<button class="btn btn-sm btn-outline-danger js-sweetalert deleteTraining" data-toggle="tooltip" title="Delete User" value="'+dato.id_user+'"><i class="fa fa-trash-o"></i> </button>';
           }
           return buttons;
    },
    status:function(dato){
        var status='';
        if(dato.status_user== 1 || dato.status_user== "1"){
            status +="<span class='badge badge-success'>Activated</span>";
        }else if(dato.status_user == 2 || dato.status_user== "2"){
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
            trainer:$('#trainerSearch').val(),
            work:$('#worktypesearch').val(),
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
    get_weeks_T:function (numWeek,start_training,end_training) {
        var url = $('#url').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            type:"POST",
            url:url+'/generateWeekTraining',
            data:{numWeek:numWeek, start_training:start_training, end_training:end_training},
            dataType:"json",
            success: function(data){
                console.log(data);

                switch (data.num['flag']) {
                    case 1:
                        $('#numWeek').val(data.num['num']);
                        $('#numWeek2').val(data.num['num']);
                        break;
                    case 2:
                        $('#end_training').val(data.end_training);
                        $('#end_training').trigger('change');
                        break;
                
                    default:
                        break;
                }


                // $('#flag').val(data.flag);

                // $('#end_training').val(data.end_training);
                // $('#end_training').trigger('change');
                // $('#numWeek').val(data.num);
            },
            error: function(err){
                console.log(err);
            }
        });
    },

    get_weeks_C:function (numWeek_C,end_training,end_coaching) {
        var url = $('#url').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            type:"POST",
            url:url+'/generateWeekCoaching',
            data:{numWeek_C:numWeek_C, end_training:end_training, end_coaching:end_coaching},
            dataType:"json",
            success: function(data){
                console.log(data);

                switch (data.num['flag']) {
                    case 1:
                        $('#numWeek_C').val(data.num['num']);
                        $('#numWeek_C2').val(data.num['num']);
                        break;
                    case 2:
                        $('#end_coaching').val(data.end_coaching);
                        $('#end_coaching').trigger('change');
                        break;
                
                    default:
                        break;
                }
            },
            error: function(err){
                console.log(err);
            }
        });
    },
    get_atwork: function(dato){
        var types='';
         if(dato.type== 2 ||dato.type== "2"){
            types = '<span class="badge badge-training">Training</span>';
        }else if(dato.type == 3 ||dato.type== "3"){
            types = '<span class="badge badge-coaching">Coaching</span>';
        }
        return types;
    },
}
const success = {

    new_update: function (data,state){
        console.log(data);
        var dato = data;
        $('#btn-save').attr('disabled', false);
        $("#table-row").remove();
        $.notifyClose();
        switch (dato.No) {
            case 1:
                swal({
                    title: "Datos Existentes",
                    text: dato.msg,
                    type: "warning",
    
                  });
                break;
            case 2:
                swal({
                    title: "Error",
                    text: dato.msg,
                    type: "error",
    
                  });
            break;
        
            default:
                var training2 = `<tr id="trainings_id${dato.id_user}" class="rowTraining">
                    <td style ="background:${dato.color}">${dato.client }</td>
                    <td>${dato.name} ${dato.lastname}</td>
                    <td>${dato.name_trainer} ${dato.lastname_trainer}</td>
                    <td style ="background:${dato.color}">${dato.time_s} - ${dato.time_e}</td>
                    <td>${dato.setting}</td>
                    <td>${training.get_atwork(dato)}</td>
                    <td class="hidden-xs" >Zoom</td>
                    <td class="hidden-xs" >Activities</td>
                    <td>${dato.end_training}</td>
                    <td class="hidden-xs">${training.status(dato)}</td>
                    <td>${training.button(dato)}</td>
                </tr>`;

                if (state == "add"){ 
                    $("#trainings-list").append(training2);
                    $("#trainings_id"+dato.id_user).css("background-color", "#c3e6cb");    
                }else{
                    $("#trainings_id"+dato.id_user).replaceWith(training2);
                    $("#trainings_id"+dato.id_user).css("background-color", "#ffdf7e");  
                }
                $('#traineeNewForm').trigger("reset");
                $('#formTraining').hide();
                $(".bodyIndex").show();
                $("#btn_add").show();

                if ($('.rowTraining').length == 0) {
                    $('#table-row').show();
                }
                break;
        }
        
    },

    deactivated:function(data) {
        console.log(data);
        var dato = data;
        if(dato.status_user != 0){
            var training2 =`<tr id="trainings_id${dato.id_user}" class="rowTraining">
                <td style ="background:${dato.color}">${dato.client }</td>
                <td>${dato.name} ${dato.lastname}</td>
                <td>${dato.name_trainer} ${dato.lastname_trainer}</td>
                <td style ="background:${dato.color}">${dato.time_s} - ${dato.time_e}</td>
                <td>${dato.setting}</td>
                <td>${training.get_atwork(dato)}</td>
                <td class="hidden-xs" >Zoom</td>
                <td class="hidden-xs" >Activities</td>
                <td>${dato.end_training}</td>
                <td class="hidden-xs">${training.status(dato)}</td>
                <td>${training.button(dato)}</td>
            </tr>`;
          
            $("#trainings_id"+dato.id_user).replaceWith(training2);
            if(dato.status_user == 1 || dato.status_user == "1"){
                color ="#c3e6cb";
            }else if(dato.status_user == 2 ||dato.status_user == "2"){
                color ="#ed969e";
            }
            $("#trainings_id"+dato.id_user).css("background-color", color); 

        }else if(dato.status_user == 0){
            $("#trainings_id"+dato.id_user).remove();
            if ($('.rowTraining').length == 0) {
                var training3 = `<tr id="table-row" class="text-center">
                                    <th colspan="7" class="text-center">
                                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                                     </th>
                                </tr>`;

                $("#trainings-list").append(training3);
              }
        }
       
    },

    show: function(data){
        console.log(data);
        $('#training_id').val(data.id);
        $('#name').val(data.name);
        $('#id_option').val(data.id_option);
        $('#btn-save').val("update");
        $('#myModalLabel').html(`Update Settings <i class="fa fa-user-plus"></i>`);
        $('#myModal').modal('show');
    },

    msj: function(data){
        console.log(data);
        $('#btn-save').attr('disabled', false);
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



    
