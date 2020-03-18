$(document).ready(function(){
    var nameDeli='<a href="/reports">Reports</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar10').addClass('active');  


    $('#view-incident').click(function(){
        $('#labelTitle').html("Incident Report  <i class='fa fa-file-excel-o'></i>");
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
        $('.table-incident').show();
        $('.view-search-incident').show();
    
    });

    $('#view-attendance').click(function(){
        $('#labelTitle').html("Attendance Report  <i class='fa fa-file-excel-o'></i>");
        $("#incident").hide();
        $("#attendance").hide();
        $('.table-incident').hide();
        $('.table-attendance').show();
        $('.view-search-incident').hide();
    
    });


    $(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            }else{
                incident_report.get_data(page);
            }
        }
    });

    $('.incident_reportSearch').change(function(){
        incident_report.get_data(1);
    });


});

const incident_report = {
    get_data: function(page){
        var formData={
            client: $('#clientSearch').val(),
            date_start: $('#startSearch').val(),
            date_end: $('#endSearch').val(),
            operator: $('#operatorSearch').val(),
        }
        $('.loading-table').show();
        console.log(formData);
        $.ajax(
        {
            url: '?page=' + page,
            data:formData,
            type: "get",
            datatype: "html"
        }).done(function(data){
            $('.pagination').remove();
            $('.loading-table').hide();
            $("#tag_container").empty().html(data);
            location.hash = page;
           
        }).fail(function(jqXHR, ajaxOptions, thrownError){
              alert('No response from server');
        });
    },
}