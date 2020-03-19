$(document).ready(function(){

    // change view
    var url = $('#url').val();
    var baseUrl = $('#baseUrl').val();

    select(baseUrl + '/reason', "#reason");
    select(baseUrl + '/supervisor', "#supervisor");

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
                var my_url = baseUrl + '/incident';
                incident.edit_create("POST",my_url,state,"");
            } 
            else {
                swal("Cancelled", "error");
            }
        });

    });

    $("#btn-cancel-incident").click(function(e){
        e.preventDefault();
        //borrar incidena
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
                location.href = url;
            } 
        });
       
    })

    //SAVE OPERATOR
    $("#formIncident").on('submit',function (e) {

        e.preventDefault(); 
        
        $('#btn-save-incident').attr('disabled', true);

        var formData = {
            reason: $("#reason").val(),
            supervisor: $("#supervisor").val(),
            note: $("#note").val()
        }

        var state = $('#btn-save-incident').val();
        var type = "PUT"; //for creating new resource
        var my_url = baseUrl + '/incident';

        incident.edit_create(type,my_url,state,formData);
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
                var incident = `
                    <tr>
                        <td>${data.result.created_at}</td>
                        <td>${data.result.name} ${data.result.last_name}</td>
                        <td>${data.result.setting_name}</td>
                        <td>${data.result.supervisor_name} ${data.result.supervisor_last_name}</td>
                        <td>${data.result.duration}</td>
                        <td>${data.result.start}</td>
                        <td>${data.result.end}</td>
                    </tr>
                `;

                $("#incident-list").append(incident);
                $('#formIncident').trigger('reset');

                $("#btn-incident").attr('disabled', false);
                $("#btn-incident").removeClass('icon-menu d-none d-sm-block d-md-none d-lg-block btn btn-warning');
                $("#btn-incident").addClass('icon-menu d-none d-sm-block d-md-none d-lg-block btn btn-danger');
                
                clearInterval(timer);
                $("#labelTimer").html("00:00:00");
                fecha = new Date();
                var fecha = moment(fecha).format('YYYY-MM-DD');


                $("#labelDate").html(fecha);
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
            $('#name').addClass('border-dange');
        });
        
    }
}