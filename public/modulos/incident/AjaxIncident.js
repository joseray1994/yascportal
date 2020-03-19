$(document).ready(function(){

    // change view
    var baseUrl = $('#baseUrl').val();
    $("#btn-incident").click(function(e){
        e.preventDefault();
        $("#documenter_cover").hide();
        $("#incidentReport").show();
        $('#tag_put').remove();

        var state = $('#btn-save-incident').val();
        var my_url = baseUrl + '/incident';
        incident.edit_create("POST",my_url,state,"");
    });
    
    select(baseUrl + '/reason', "#reason");
    select(baseUrl + '/supervisor', "#supervisor");

    //SAVE OPERATOR
    $("#formIncident").on('submit',function (e) {

        e.preventDefault(); 
        
        // $('#btn-save').attr('disabled', true);
        
        // var formData = new FormData(this);
        // var formData = $("#formOperators").serialize();
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
   
    // var start = Date.now(); 
    count = document.getElementById('labelTimer');
    labelDate = document.getElementById('labelDate');
    
    var start = new Date(time_start).getTime();

    var date = moment(time_start).format('YYYY-MM-DD');
    labelDate.innerHTML = date;

    var x = setInterval(function() {
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
        console.log(data);
        switch(data.flag){
            case 1:
                $('#tag_put').remove();
                $form = $('#formIncident');
                $form.append('<input type="hidden" id="tag_put" name="_method" value="PUT">');
                startTime(data.incident.start);
                swal("Warning", data.msg, "warning");
            break;
            default:
                startTime(data.start);

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