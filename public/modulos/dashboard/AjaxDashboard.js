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
    $(".section-comment"+id).fadeToggle();
    $("#inputComment"+id).focus();
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