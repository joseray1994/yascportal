$(document).ready(function(){
    var nameDeli='<a href="/reports">Incidents</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar10').addClass('active');  


    $('#view-incident').click(function(){
        $('#labelTitle').html("Incident Report  <i class='fa fa-file-excel-o'></i>");
        $("#incident").hide();
        $("#attendance").hide();
        $('.table-incident').show();
        $('.view-search').show();
    
    });

});