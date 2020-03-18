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
        $('#btn-save').val("add");
        $('#traineeNewForm').trigger("reset");
        $('#myModalLabel').html(`Create New Trainee `);
        // $("#image").attr('src','');
        $(".bodyIndex").hide();
        $('#formCU').show();
        $("#flag").val(false);

        
    });
       //display modal form for creating new product *********************
    $('.cancel-cu').click(function(){
        $('#btn-save').val("add");
        $('#traineeNewForm').trigger("reset");
        $('#myModalLabel').html(`Create New Trainee`);
        // $("#image").attr('src','');
        $('#formCU').hide();
        $(".bodyIndex").show();
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
        var start_training=$('#start_training').val();
        var end_training=$('#end_training').val();
        
        training.get_weeks_T(numWeek,start_training,end_training);
    });

    $('#numWeek').keyup(function(){
        var numWeek = $('#numWeek').val();
        var start_training=$('#start_training').val();
        var end_training=$('#end_training').val();
        if (numWeek>0) {
            training.get_weeks_T(numWeek,start_training,end_training);
            
        }
        $('#flag').val(0);
    });

    $('.n_weeks_coaching').change(function(){
        var numWeek_C = $('#numWeek_C').val();
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
                    title= "Do you want to activate this option?";
                    text="The Option will be activated";
                    confirmButtonText="Activate";

                    datatitle="Activated";
                    datatext="activated";
                    datatext2="Activation";
                }
                else 
                {
                    title= "Do you want to disable this option?";
                    text= "The Option will be deactivated";
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
                    swal(datatitle, "Option "+datatext, "success");
                    actions.deactivated(my_url);
                    } 
                    else {
                    
                    swal("Cancelled", datatext2+" cancelled", "error");
                
                    }
            });
        });

    //delete product and remove it from TABLE list ***************************
    $(document).on('click','.deleteSettings',function(){
        var privada_id = $(this).val();
        var my_url = url + '/delete/' + privada_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Are you sure you wish to delete this option?",
            text: "All records with this option will be modified",
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
            if(dato.status== 1){
               buttons += ' <button class="btn  btn-sm btn-outline-secondary open_modal"  data-toggle="tooltip" title="Edit"  value="'+dato.id+'"> <i class="fa fa-edit"></i></li></button>';
               buttons += '	<button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-type" title="Deactivated" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-window-close"></i></button>';
          
           }else if(dato.status == 2){
               buttons+='<button type="button" class="btn btn-sm btn-outline-success off-type" title="Activated" data-type="confirm" value="'+dato.id+'" ><i class="fa fa-check-square-o"></i></button>'
               buttons += '<button class="btn btn-sm btn-outline-danger js-sweetalert deleteSettings" data-toggle="tooltip" title="Delete" value="'+dato.id+'"><i class="fa fa-trash-o"></i> </button>';
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
    }
}
const success = {

    new_update: function (data,state){
        console.log(data);
        var dato = data;
        var typename =$('#name').val();
        var type =$('#id_option').val();
        $('#btn-save').attr('disabled', false);


        switch (dato.No) {
            case 1:
                swal({
                    title: "Datos Existentes",
                    text: dato.msg,
                    type: "warning",
    
                  });
                break;
            case 2:
            
            break;
        
            default:
                var setting = `<tr id="training_id${dato.id}">
                    <td>${dato.id}</td>
                    <td>${dato.name}</td>
                    <td>${dato.option}</td>
                    <td class="hidden-xs">${settings2.status(dato)}</td>
                    <td>${settings2.button(dato)}</td>
                </tr>`;

                if (state == "add"){ 
                    $("#settings-list").append(setting);
                    $("#training_id"+dato.id).css("background-color", "#c3e6cb");    
                }else{
                    $("#training_id"+dato.id).replaceWith(setting);
                    $("#training_id"+dato.id).css("background-color", "#ffdf7e");  
                }
                $('#formCU').hide();
                $(".bodyIndex").show();
                break;
        }
        
    },

    deactivated:function(data) {
        console.log(data);
        var dato = data;
        if(dato.status != 0){
            var setting = `<tr id="training_id${dato.id}">
                <td>${dato.id}</td>
                <td>${dato.name}</td>
                <td>${dato.option}</td>
                <td class="hidden-xs">${settings2.status(dato)}</td>
                <td>${settings2.button(dato)}</td>
            </tr>`;
          
            $("#training_id"+dato.id).replaceWith(setting);
            if(dato.status == 1){
                color ="#c3e6cb";
            }else if(dato.status == 2){
                color ="#ed969e";
            }
            $("#training_id"+dato.id).css("background-color", color); 

        }else if(dato.status == 0){
            $("#training_id"+dato.id).remove();
            if ($('.rowTraining').length == 0) {
                var training = `<tr id="table-row" class="text-center">
                                    <th colspan="7" class="text-center">
                                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                                     </th>
                                </tr>`;

                $("#training-list").append(training);
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



    
