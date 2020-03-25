$(document).ready(function() {
    var url = $('#url').val();
    var baseUrl = $('#baseUrl').val();
    var nameDeli='<a href="/home">Dashboard</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar13').addClass('active'); 
    
    // LIKES
    $(".btn-like").click(function(e){
        e.preventDefault();
        id = $(this).val();
    });
});

function toggleDescription(id) {

    moreText = document.getElementById('more'+id);
    if ( moreText.style.display === "none") {
        $("#more"+id).show();
        $("#titleBtnRead"+id).html("Read Less");
    } else {
        $("#more"+id).hide();
        $("#titleBtnRead"+id).html("Read More");
    }
}
function toggleComments(id) {

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

            $(".section-comment"+id).fadeToggle();
            $("#inputComment"+id).focus();
        },
        error: function(err){
            console.log(err);
        }
    });
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
           console.log(data);
        },
        error: function(err){
            console.log(err);
        }
    });
}