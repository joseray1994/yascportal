$(document).ready(function(){
    clearload();
    var url = $('#url').val();
    var baseUrl = $('#baseUrl').val();
    var nameDeli='<a href="/news">News</i></a>';
    $('.nameDeli').html(nameDeli);

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

    $('#sidebar13').addClass('active'); 
    
    // BTN NEW
    $('#btn_add').click(function(){
        $('#labelTitle').html("Add News  <i class='fa fa-tasks'></i>");
        $(".formulario").show();
        $(".tablaNews").hide();
        $("#btn_add").hide();
        $('#btn-save').val("add");
        $("#formNews").trigger('reset');
        $('#tag_put').remove();
        $('.selectpick').selectpicker("selectAll");
        CKEDITOR.instances['ckeditor'].setData("");


        var drEvent = $('.dropify-event').dropify();
        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();
        drEvent.clearElement();
        drEvent.settings.defaultFile = "";
        drEvent.destroy();
        drEvent.init();
    });
    //BTN CANCEL
    $('.btn-cancel').click(function(){
        $('#labelTitle').html("News  <i class='fa fa-tasks'></i>");
        $(".formulario").hide();
        $(".tablaNews").show();
        $("#btn_add").show();
        $("#formNews").trigger('reset');
        $('#tag_put').remove();
        CKEDITOR.instances['ckeditor'].setData("");
    });

    //SAVE OPERATOR
    $("#formNews").on('submit',function (e) {

        e.preventDefault(); 
        $('#btn-save').attr('disabled', true);
        
        var formData = new FormData(this);
        formData.append('description', CKEDITOR.instances['ckeditor'].getData());
        // var formData = $("#formNews").serialize();
        var state = $('#btn-save').val();
        var id = $('#id_hidden').val();
        var type = "POST"; //for creating new resource
        var my_url = url;
        var file = "file";
        if (state == "update"){
            type = "POST"; //for updating existing resource
            my_url += '/' + id;
        }

        actions.edit_create(type,my_url,state,formData, file);
    });

     //SHOW
     $(document).on('click','.btn-edit',function(){
        getTypes();
        var id = $(this).val();
        var my_url = url + '/' + id;

        $('#labelTitle').html("Edit News  <i class='fa fa-tasks'></i>");
        $(".formulario").show();
        $(".tablaNews").hide();
        $("#btn_add").hide();
        $('#btn-save').val("update");
        $("#formNews").trigger('reset');
        $('#tag_put').remove();

        actions.show(my_url);
    });

    //DELETE
$(document).on('click','.delete-op',function(){
        var id = $(this).val();
        var my_url = url + '/' + id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
            title: "Are you sure you wish to delete this News?",
            text: "the news will be deleted",
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

    var drEvent = $('.dropify-event').dropify();
    drEvent.on('dropify.beforeClear', function(event, element) {
        $("#flag_hidden").val(true);
    });

 });      

// Detail
function showDetail(id) {
    var url = $('#url').val();
    var my_url = url + '/' + id;

    actions.modal(my_url);
}

function getTypes()
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })       
    $.ajax({
        type: 'GET',
        url: baseUrl+'/getTypes',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var html = '';
            $.each(data, function (key, val) {
                html+= "<option value='"+val.id+"'>"+ val.name+"</option>"
        });
        $('#id_type_user').html(html); 
        
        },
        error: function (data) {
            console.log(data);
            

        }
        }); 
}


const types ={
    button: function(dato){
           var buttons='<div>';
            if(dato.status== 1){
               buttons += ` <button type="button" class="btn btn-sm btn-outline-info open-modal" onclick="showDetail(${dato.id})" data-toggle="tooltip" title="Detail" value="${dato.id}"  ><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-edit" data-toggle="tooltip" title="Edit" value="${dato.id}"  ><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert delete-op" data-toggle="tooltip" title="Delete" data-type="confirm" value="${dato.id}"><i class="fa fa-window-close"></i></button>
               ` ;
          
           }else if(dato.status == 2){
               buttons  += ` <button type="button" class="btn btn-sm btn-outline-info open-modal" onclick="showDetail(${dato.id})" data-toggle="tooltip" title="Detail" value="${dato.id}"  ><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-edit" data-toggle="tooltip" title="Edit" value="${dato.id}"  ><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert delete-op" data-toggle="tooltip" title="Delete" data-type="confirm" value="${dato.id}"><i class="fa fa-window-close"></i></button>
                            `
           }
           buttons+='</div>';
           return buttons;
    },
    status:function(dato){
        var status='';
        if(dato.status== 1){
            status +="<span class='badge badge-success'>With Comments</span>";
        }else if(dato.status == 2){
            status +="<span class='badge badge-secondary'>Without Comments</span>";
        }else if(dato.status == 3){
            status +="<span class='badge badge-secondary'>Deactivated</span>";
        }
       return status;
    },

}
 
const success = { 
    new_update: function (data,state){
        console.log(data);
        $('#labelTitle').html("News <i class='fa fa-tasks'></i>");
        $('#btn-save').attr('disabled', false);
        $("#table-row").remove();
        $("#no-data-doc").hide();
        var dato = data;

        var news = `<tr id="news_id${dato.id}" class="rowType">
            <td>${dato.id}</td>
            <td>${dato.title}</td>
            <td>${dato.name} ${dato.last_name}</td>
            <td>${dato.created_at}</td>
            <td class="hidden-xs">${types.status(dato)}</td>
            <td>${types.button(dato)}</td>
        </tr>`;

        if (state == "add"){ 
            $("#news-list").prepend(news);
            $("#news_id"+dato.id).css("background-color", "#c3e6cb");    
        }else{
            $("#news_id"+dato.id).replaceWith(news);
            $("#news_id"+dato.id).css("background-color", "#ffdf7e");  
        }

        $('#formNews').trigger("reset");
        $(".formulario").hide();
        $(".tablaNews").show();
        $("#btn_add").show();
        CKEDITOR.instances['ckeditor'].setData("");


        if ($('.rowType').length == 0) {
            $('#table-row').show();
        }
                
    },
    show: function(dato){
        console.log(dato);
        $('#tag_put').remove();
        $form = $('#formNews');
        $form.append('<input type="hidden" id="tag_put" name="_method" value="PUT">');
        data = dato.data;
        $("#title").val(data.title);
        $('#id_hidden').val(data.id);
        $('#status').val(data.status);
        CKEDITOR.instances['ckeditor'].setData(data.description);
        
        var baseUrl = $('#baseUrl').val();
        if(data.path != ""){
            var rutaImage = baseUrl + data.path;
        }else{
            //default
            var rutaImage = "";
        }
            
        var drEvent = $('.dropify-event').dropify(
            {
                defaultFile: rutaImage
            });
            drEvent = drEvent.data('dropify');
            drEvent.resetPreview();
            drEvent.settings.defaultFile = rutaImage;
            drEvent.destroy();
            drEvent.init();

        $.each(dato.types, function (key, val) {
            $('.selectpick option[value=' + val.id_type_user + ']').attr('selected', true);
        });
        $('.selectpick').selectpicker('refresh'); 
        

    },
    modal: function(dato){
        data = dato.data;
        $("#labelTitleModal").html(data.title);
        $("#labelDescriptionNews").html(data.description);
        var baseUrl = $('#baseUrl').val();

        if(data.path != ""){
            var rutaImage = baseUrl + data.path;
            $("#picture_news").attr('src', rutaImage);
            $(".seccion-image").show();
        }else{
            $(".seccion-image").hide();
        }
        $("#modalDetail").modal('show');
    },  
    deactivated:  function(data){
        console.log(data);
        var dato = data;
        $.notifyClose();
     
        if(dato.status != 0){


            var news = `<tr id="news_id${dato.id}">
                <td>${dato.id}</td>
                <td>${dato.title}</td>
                <td>${dato.name} ${dato.last_name}</td>
                <td>${dato.created_at}</td>
                <td class="hidden-xs">${types.status(dato)}</td>
                <td>${types.button(dato)}</td>
            </tr>`;
            
            $("#news_id"+dato.id).replaceWith(news);
            if(dato.status == 1){
                color ="#c3e6cb";
            }else if(dato.status == 2){
                color ="#ed969e";
            }
            $("#news_id"+dato.id).css("background-color", color);  
            
        }else if(dato.status == 0){
            
            $("#news_id"+dato.id).remove();
            if($("#tag_container tr").length == 1){
                $("#tag_container").append(` <tr id="table-row" class="text-center">
                                                    <th colspan="8" class="text-center">
                                                        <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                                                    </th>
                                                </tr>`);

            }
        }      
    },
    msj: function(data){
        $('#btn-save').attr('disabled', false);
        $('#btn-save-documents').attr('disabled', false);
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
       