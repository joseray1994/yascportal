$(document).ready(function(){
    clearload();
    var nameDeli='<a href="/reports">Reports</i></a>';
    $('.nameDeli').html(nameDeli);
    $('#sidebar10').addClass('active');  


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
    //export csv
  $('#csv').on('click',function(){
    $("#tag_container_incident").tableHTMLExport({type:'csv',filename:`incident.csv`});
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
            $("#tag_container_incident").empty().html(data);
            location.hash = page;
           
        }).fail(function(jqXHR, ajaxOptions, thrownError){
              alert('No response from server');
        });
    },
}