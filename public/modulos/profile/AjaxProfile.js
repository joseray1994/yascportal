$(function() {
    $('.dropify').dropify();
    var radioState;
    var baseUrl = $("#baseUrl").val();
    var nameDeli='<a href="/profile">Profile</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#tag_put').remove();
    $form = $('#formProfile');
    $form.append('<input type="hidden" id="tag_put" name="_method" value="PUT">');
        
    $(".pass").hide();
    disablePassInput();
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

    $(".btn-cancel").click(function(e){
        e.preventDefault(); 
        $("#Settings").removeClass("active");
        $("#Overview").addClass("active");
        $("#btnSettings").removeClass("active");
        $("#btnOverview").addClass("active");
    })

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
      //Download
      $(document).on('click','.download',function(){
        
        var id = $(this).val();
        var mat = $("#mat").val();
        var my_url = baseUrl + '/download/' + id + '/' + mat;
       
        actions.show(my_url);
        window.location.replace(my_url);
       
    });
});
const success = { 
    new_update: function (data,state){
        $('#btn-save').attr('disabled', false);
        console.log(data);
        $.notifyClose();
        switch (data.No) {
            case 2:
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
                var baseUrl = $('#baseUrl').val();
                var rutaImage = baseUrl + data.path_image;
        
                $("#user_photo").attr('src', rutaImage );
                $("#image-profile").attr('src', rutaImage );
                  
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
                
                $('#btn-save').attr('disabled', false);
                $("#Settings").removeClass("active");
                $("#Overview").addClass("active");
                $("#btnSettings").removeClass("active");
                $("#btnOverview").addClass("active");
        
                $("#label_nickname").html(data.nickname);
                $("#nick_user").html(data.nickname);
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
               
            break;
        }

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
       