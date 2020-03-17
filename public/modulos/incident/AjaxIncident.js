$(document).ready(function(){

    // change view
    $("#btn-incident").click(function(e){
        e.preventDefault();
        $("#documenter_cover").hide();
        $("#incidentReport").show();
    });
}); 