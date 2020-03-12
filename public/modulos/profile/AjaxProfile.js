$(function() {
    $('.dropify').dropify();
    var radioState;
    image = $("#imagen").val();
    $('#tag_put').remove();
    $form = $('#formProfile');
    $form.append('<input type="hidden" id="tag_put" name="_method" value="PUT">');
    var baseUrl = $('#baseUrl').val();
    var rutaImage = baseUrl + '/images/operators/' +image;
    $("#image-profile").attr('src',rutaImage );
      
    var drEvent = $('#dropify-event').dropify(
        {
            defaultFile: rutaImage
        });
        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();
        drEvent.clearElement();
        drEvent.settings.defaultFile = rutaImage;
        drEvent.destroy();
        drEvent.init();
        
    $(".pass").hide();
    function disablePassInput()
    {
        $('#password').attr('disabled','disabled');
        $('#password_confirmation').attr('disabled','disabled');
    }

    function enablePassInput()
    {
        $('#password').removeAttr('disabled');
        $('#password_confirmation').removeAttr('disabled');
    }


    $("#show_pass").on("click", function(e) {
        if (radioState === this) {
            $(".pass").hide();
            disablePassInput()
            this.checked = false;
            radioState = null;
        } else {
            $(".pass").show();
            enablePassInput()
            console.log("false");
            radioState = this;
        }
    });

    //SAVE OPERATOR
    $("#formProfile").on('submit',function (e) {

        e.preventDefault(); 
        $('#btn-save').attr('disabled', true);
        
        var formData = new FormData(this);
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var my_url = baseUrl + '/profile';
        var file = "file";

        actions.edit_create(type,my_url,state,formData, file);
    });
});
const success = { 
    new_update: function (data,state){
        
        $('#btn-save').attr('disabled', false);
        $("#Settings").removeClass("active");
        $("#Overview").addClass("active");
        $("#btnSettings").removeClass("active");
        $("#btnOverview").addClass("active");

        $("#label_name").html(data.name);
        $("#label_last_name").html(data.last_name);
        $("#label_notes").html(data.notes);
        $("#label_description").html(data.description);
        $("#label_address").html(data.address);
        $("#label_phone").html(data.phone);
        $("#label_birthdate").html(data.birthdate);
        $("#label_contact_name").html(data.emergency_contact_name);
        $("#label_contact_phone").html(data.emergency_contact_phone);

        $.notifyClose();
                
        $.notify({
            // options
            title: "Success!",
            message:"Updated information",
        },{
            // settings
            type: 'success'
        });
       
    },

    msj: function(data){
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
            $('#name').addClass('border-dange');
        });
        
    }
}
       