var baseUrl = $('#baseUrl').val();

    //display modal form for creating new product *********************
    $('#startShift').click(function(){
        swal({
            title: "Do you want to start your shift?",
            text: "The Option will be activated",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    type:"GET",
                    url:baseUrl + '/startShift',
                    success: function(data){
                      console.log(data);
                      $('.startShift').hide();
                      $('.endShift').show();
                    },
                    error: function(err){
                        console.log(err.responseJSON.error);
                        $.notifyClose();
                            $.notify({
                                // options
                                title: "Error!",
                                message:err.responseJSON.error,
                            },{
                                // settings
                                type: 'danger'
                            });
                    }
                });
            } 
            else {
            
            // swal("Cancelled", datatext2+" cancelled", "error");
        
            }
        });
        // $('#btn-save').val("add");
        // $('#traineeNewForm').trigger("reset");
        // $('#myModalLabel').html(`Create New Trainee `);
        // // $("#image").attr('src','');
        // $(".bodyIndex").hide();
        // $('#formCU').show();
        
    });

    $("#endShift").on("click", function(e) {
        swal({
            title: "Do you want to end your shift?",
            text: "The Option will be activated",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    type:"GET",
                    url:baseUrl + '/endShift',
                    success: function(data){
                      console.log(data);
                      $('.startShift').show();
                      $('.endShift').hide();
                    },
                    error: function(err){
                        
                        console.log(err);
                    }
                });
            } 
            else {
            
            // swal("Cancelled", datatext2+" cancelled", "error");
        
            }
        });
        // $('#btn-save').val("add");
        // $('#traineeNewForm').trigger("reset");
        // $('#myModalLabel').html(`Create New Trainee `);
        // // $("#image").attr('src','');
        // $(".bodyIndex").hide();
        // $('#formCU').show();
        
    });



    
