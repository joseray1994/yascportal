$(document).ready(function() {
    var url = $('#url').val();
    var baseUrl = $('#baseUrl').val();
    var nameDeli='<a href="/home">Dashboard</i></a>';
    $('.nameDeli').html(nameDeli);
});

function toggleDescription(id) {

    moreText = document.getElementById('more'+id);
    if ( moreText.style.display === "none") {
        $("#more"+id).show();
        $("#titleBtnRead"+id).html("Read Less");
    } else {
        $("#more"+id).hide();
        $("#titleBtnRead"+id).html("Read More...");
    }
}
function getComments(id) {
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    $.ajax({
        type:"POST",
        url:baseUrl+'/getComments',
        data:{id:id},
        dataType:"json",
        success: function(data){
            console.log(data);
           
            var totalComments = data.length;

            if(totalComments > 1){
                var labelComment = " Comments";
            }else{
                var labelComment = " Comment";
            }

            $("#totalComments"+id).html(totalComments + labelComment);
            $("#totalCommentsLabel"+id).html(totalComments);

            var comments = ``;
            data.forEach(function(data){
                comments += `
                    <li class="row clearfix">
                                            
                        <div class="icon-box col-md-2 col-4">
                            <div class="icon">
                                <img src="${baseUrl}${data.path_image}" class="rounded-lg user-photo" style="max-width:40px" alt="user_picture">
                            </div>
                        </div>
                        <div class="text-box col-md-10 col-8 p-l-0 p-r0">
                            <h5 class="m-b-0">${data.nickname} </h5>
                            <p>${data.comment} </p>
                            <ul class="list-inline">
                                <li><a href="javascript:void(0);">${data.created_at}</a></li>
                            </ul>
                        </div>
                    </li>
                `;
            });
            $("#comments"+id).html(comments);
           
        },
        error: function(err){
            console.log(err);
        }
    });
}

function toggleComments(id){
    getComments(id);
    seccionComment = document.getElementsByClassName('section-comment'+id);
            
    if (seccionComment[0].style.display === "none") {
        $(".section-comment"+id).show();
        location.href = "#comment"+id;
    } else {
        $(".section-comment"+id).hide();
        location.href = "#news"+id;
    }
}

function addLike(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    $.ajax({
        type:"POST",
        url:baseUrl+'/like',
        data:{id:id},
        dataType:"json",
        success: function(data){
            console.log(data);
            if(data.status === 1){
                $("#btnLikes"+id).removeClass('icon-heart btn-like btn btn-secondary');
                $("#btnLikes"+id).addClass('icon-heart btn-like btn btn-danger');
                $("#countLikes"+id).html(data.likes);
            }else{
                $("#btnLikes"+id).removeClass('icon-heart btn-like btn btn-danger');
                $("#btnLikes"+id).addClass('icon-heart btn-like btn btn-secondary');
                $("#countLikes"+id).html(data.likes);
            }
        },
        error: function(err){
            console.log(err);
        }
    });
}

function addComment(id){
    var formData = {
        id: id,
        comment: $("#inputComment"+id).val()
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    $.ajax({
        type:"POST",
        url:baseUrl+'/addComments',
        data:formData,
        dataType:"json",
        success: function(data){
           $("#inputComment"+id).val('');
           getComments(id);
        },
        error: function(err){
            console.log(err);
        }
    });
}