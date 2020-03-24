$(document).ready(function(){
    clearload();
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

    var nameDeli='<a href="/zoom">Zoom</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar10').addClass('active');  

    var url = $('#url').val();

     //change view to create zoom
     $('#btn_add').click(function(){
        $('#labelTitle').html("New Zoom  <i class='fa fa-video-camera'></i>");
        $(".formulario-zoom").show();
        $(".tableZoom").hide();
        $('#btn-save').val("add");
        $('#btn_add').hide();
        $('#formZoom').trigger("reset");
        $('#tag_put').remove();
    
    });

    $('.btn-cancel').click(function(){
        $('#labelTitle').html("Zoom  <i class='fa fa-video-camera'></i>");
        $(".formulario-zoom").hide();
        $(".tableZoom").show();
        $('#btn_add').show();
        $('#formZoom').trigger("reset");
        $('#tag_put').remove();
    
    });

    $(document).on('click','.btn_add_user',function(){
        $('#btn-save-user').val("add");
        $('#myModal').modal('show');
       
    });

     //Create Clients
     $("#assignForm").on('submit',function (e) {
        console.log('button');
      
        e.preventDefault(); 
        var formData =  $("#assignForm").serialize();
     
        var type = "PUT"; //for creating new resource
        var zoom_id = $(this).val();
        var my_url = url;
        var state = 'update';
        my_url += '/update' + zoom_id;
            console.log(formData);
            actions.edit_create(type,my_url,state,formData);   
          
    
    });


});

  