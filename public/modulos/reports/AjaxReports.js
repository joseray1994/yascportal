$(document).ready(function(){
    var nameDeli='<a href="/reports">Reports</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar10').addClass('active');  

    var url = $('#url').val();
    $('#view-incident').click(function(){
        location.href = url + '/incident';
    });
    
    $('#view-attendance').click(function(){
        location.href = url + '/attendance';

        var my_url = url + '/attendance';
        actions.show(my_url);
    });

});

  