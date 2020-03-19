$(document).ready(function(){
    var nameDeli='<a href="/reports">Reports</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar10').addClass('active');  

    //Actions for buttons
    $('#view-attendance').click(function(){
        $('#labelTitle').html("Attendance Report  <i class='fa fa-file-excel-o'></i>");
        $("#incident").hide();
        $("#attendance").hide();
        $("#focus").hide();
        $("#medical_bureau").hide();
        $("#tel_us").hide();
        $("#speedez").hide();
        $("#etzel").hide();
        $("#call_experts").hide();
        $("#edwards").hide();
        $("#emerald").hide();
        $("#global").hide();
        $('.table-attendance').show();
        $('.table-incident').hide();
        $('.view-search-incident').show();
    
    });

});

  