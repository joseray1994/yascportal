$(document).ready(function(){

    // change view
    var url = $('#url').val();
    var baseUrl = $('#baseUrl').val();

    select(baseUrl + '/reason', "#id_setting");
    select(baseUrl + '/reason', "#filter_setting");
    select(baseUrl + '/supervisor', "#id_supervisor");

    $("#btn-incident").click(function(e){
        e.preventDefault();

        swal({
            title: "Warning",
            text: "Are you sure to start an incident?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Ok",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {                
                $("#documenter_cover").hide();
                $("#incidentReport").show();
                $('#tag_put').remove();
                
                var state = $('#btn-save-incident').val();
                var type = "POST";
                var my_url = baseUrl + '/incident';
                incident.list(my_url);
                incident.edit_create(type,my_url,state,"");
                $('#btn-save-incident').attr('disabled', false);
            } 
            else {
                swal("Cancelled", "error");
            }
        });

    });

    $("#btn-cancel-incident").click(function(e){
        e.preventDefault();
        var my_url = baseUrl + '/incident';
        swal({
            title: "Warning",
            text: "Are you sure to cancel this incident?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Ok",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {         
                incident.delete(my_url);
                location.href = url;
            } 
        });
       
    })

    //SAVE OPERATOR
    $("#formIncident").on('submit',function (e) {

        e.preventDefault(); 
        
        $('#btn-save-incident').attr('disabled', true);

        var formData = {
            id_setting: $("#id_setting").val(),
            id_supervisor: $("#id_supervisor").val(),
            note: $("#note").val()
        }

        var state = $('#btn-save-incident').val();
        var type = "PUT"; //for creating new resource
        var my_url = baseUrl + '/incident';

        incident.edit_create(type,my_url,state,formData);
    });

    $("#filter_setting, #filter_start, #filter_end").change(function(){
        
        var filter_setting = $("#filter_setting").val();
        var filter_start = $("#filter_start").val();
        var filter_end = $("#filter_end").val();

        var my_url = baseUrl + '/incident/getTable';

        formData = {
            filter_setting,
            filter_start,
            filter_end
        }
        incident.getTable(my_url, formData);
    });


}); 

var timer;

function select(myUrl, name){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    $.ajax({
        type: "GET",
        url:myUrl,
        success: function (data) {
            var html = `<option value="">Select</option>`;
            data.forEach(function(data){
                html += `<option value="${data.id}">${data.name}</option>`;
            });
            $(name).html(html);

        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}
function startTime(time_start){
    

    count = document.getElementById('labelTimer');
    labelDate = document.getElementById('labelDate');
    
    var start = new Date(time_start).getTime();

    var date = moment(time_start).format('YYYY-MM-DD');
    labelDate.innerHTML = date;

    timer = setInterval(function() {
        // Get todays date and time
        var now = new Date().getTime();
        var total = now - start;
        var x = total;
        // Find the distance between now and the count down date
        var tempTime = moment.duration(x);
        var dias = tempTime.days();
        var hora = tempTime.hours();
        var minutos = tempTime.minutes();
        var segundos = tempTime.seconds();

        if(hora < 10){
            hora = '0'+hora;
        }
        if(minutos < 10){
            minutos = '0'+minutos;
        }
        if(segundos < 10){
            segundos = '0'+segundos;
        }
        count.innerHTML = hora + ":" + minutos + ":"+ segundos;
    }, 1000);
    
}

function detail(id){
    var my_url = baseUrl + '/incident/' + id;
    incident.modal(my_url);
}
const incident = {
    
    edit_create: function (type,my_url,state,formData){
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                result.new_update(data,state,actions);
            },
            error: function (data) {
                console.log('Error:', data);
                result.msj(data);
            }
        });
    },
    list: function (my_url){
        $.ajax({
            type: "GET",
            url: my_url,
            dataType: 'json',
            success: function (data) {
                result.list(data);
            },
            error: function (data) {
                console.log('Error:', data);
                result.msj(data);
            }
        });
    },
    getTable: function (my_url, formData){
        $.ajax({
            type: "POST",
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                result.list(data);
            },
            error: function (data) {
                console.log('Error:', data);
                result.msj(data);
            }
        });
    },
    modal: function (my_url){
        $.ajax({
            type: "GET",
            url: my_url,
            dataType: 'json',
            success: function (data) {
                result.modal(data);
            },
            error: function (data) {
                console.log('Error:', data);
                result.msj(data);
            }
        });
    },
    delete: function(my_url){
        $.ajax({
            type: "DELETE",
            url: my_url,
            dataType: 'json',
            success: function (data) {
                result.delete(data);
            },
            error: function (data) {
                console.log('Error:', data);
                result.msj(data);
            }
        });
    },
    buttons: function(data){
        button = `<button type="button" class="btn btn-info" onclick="detail(${data.id})"><i class="fa fa-eye"></i></button>`;
        return button;
    }
}

const result = {
    new_update : function(data) {
        // console.log(data);
        $('#btn-save-incident').attr('disabled', false);
        switch(data.flag){
            case 1:
                $("#btn-incident").attr('disabled', true);
                $("#btn-incident").removeClass('icon-menu d-none d-sm-block d-md-none d-lg-block btn btn-danger');
                $("#btn-incident").addClass('icon-menu d-none d-sm-block d-md-none d-lg-block btn btn-warning');
                $('#tag_put').remove();
                $form = $('#formIncident');
                $form.append('<input type="hidden" id="tag_put" name="_method" value="PUT">');
                startTime(data.incident.start);
                swal("Warning", data.msg, "warning");
            break;
            case 2:
                var Rowincident = `
                    <tr>
                        <td>${data.result.created_at}</td>
                        <td>${data.result.name} ${data.result.last_name}</td>
                        <td>${data.result.setting_name}</td>
                        <td>${data.result.supervisor_name} ${data.result.supervisor_last_name}</td>
                        <td>${data.result.duration}</td>
                        <td>${data.result.start}</td>
                        <td>${data.result.end}</td>
                        <td>${incident.buttons(data.result)}</td>
                    </tr>
                `;

                $("#incident-list").append(Rowincident);
                $('#formIncident').trigger('reset');

                $("#btn-incident").attr('disabled', false);
                $("#btn-incident").removeClass('icon-menu d-none d-sm-block d-md-none d-lg-block btn btn-warning');
                $("#btn-incident").addClass('icon-menu d-none d-sm-block d-md-none d-lg-block btn btn-danger');
                
                clearInterval(timer);
                $("#labelTimer").html("00:00:00");
                fecha = new Date();
                var fecha = moment(fecha).format('YYYY-MM-DD');
                $("#labelDate").html(fecha);
                $('#btn-save-incident').attr('disabled', true);

                swal({
                    title: "Success",
                    text: "saved incidence",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                },
                function(isConfirm) {
                    if (isConfirm) {
                        console.log("redirects..")
                    } 
                });

            break;
            case 3:
                $("#btn-incident").attr('disabled', true);
                $("#btn-incident").removeClass('icon-menu d-none d-sm-block d-md-none d-lg-block btn btn-danger');
                $("#btn-incident").addClass('icon-menu d-none d-sm-block d-md-none d-lg-block btn btn-warning');
                startTime(data.incident.start);
            break;
        }
    },
    list: function(data){

        var tableIncident = "";
        data.forEach(function(data){

            tableIncident += `
                <tr>
                    <td>${data.created_at}</td>
                    <td>${data.name} ${data.last_name}</td>
                    <td>${data.setting_name}</td>
                    <td>${data.supervisor_name} ${data.supervisor_last_name}</td>
                    <td>${data.duration}</td>
                    <td>${data.start}</td>
                    <td>${data.end}</td>
                    <td>${incident.buttons(data)}</td>
                </tr>
            `;
        });

        $("#incident-list").html(tableIncident);
    },
    delete: function(data){
        console.log(data);
    },
    modal: function(data){
        console.log(data);
        $("#detailModal").modal('show');
        $("#labelDetailName").html(data.name + " " + data.last_name);
        $("#labelDetailDate").html(data.created_at);
        $("#labelDetailReason").html(data.setting_name);
        $("#labelDetailSupervisor").html(data.supervisor_name + " " + data.supervisor_last_name);
        $("#labelDetailDuration").html(data.duration);
        $("#labelDetailStart").html(data.start);
        $("#labelDetailEnd").html(data.end);
        $("#labelDetailNote").html(data.note);
    },
    msj: function(data){
       console.log(data);
       $('#btn-save-incident').attr('disabled', false);

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
            $('#name').addClass('border-dange');
        });
        
    }
}