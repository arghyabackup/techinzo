function delete_data(id,check_field,table_name){
    var current_location=window.location.href;
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        preConfirm: function() {
            return new Promise(function(resolve) {
                jQuery.ajax({
                    url: base_url + 'page/delete_data',
                    type: 'POST',
                    data: {id: id, check_field: check_field, table_name: table_name},
                    dataType: 'json'
                })
                .done(function(response){
                    jQuery('tbody.list_data .row_'+id).hide();
                    swal('Deleted!', response.message, response.status);
                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            });
        },
        allowOutsideClick: false
    });
}

$(function() {
    $('#userInserUpdateForm').validate({
        rules: {
            name: 'required',
            mobile: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            email: {
                required: true,
                email: true,
            },
            class: 'required',
        },
        messages: {},
        submitHandler: function(form) {

            var formdata = jQuery('#userInserUpdateForm').serialize();
            //form.submit();
            $.ajax({
                type: "POST",
                url: base_url + "page/add_update_action",
                data: formdata, // get all form field value in 
                dataType: 'json',
                success: function(resp) {
                    if (resp.flag === true) {
                        notie.alert({
                            type: 'success',
                            text: '<i class="fa fa-check"></i> ' + resp.msg,
                            time: 5,
                            position: 'top'
                        });
                        jQuery('#user-model').modal('hide');
                        jQuery('tbody.list_data .no_data').hide();
                        
                        if (resp.id == '') {
                            jQuery('tbody.list_data').prepend(resp.html);
                        }else{
                            console.log(resp.html);
                            jQuery('.row_'+resp.id).html(resp.html);
                        }

                    } else {
                        notie.alert({
                            type: 'error',
                            text: '<i class="icofont-close"></i> ' + resp.msg,
                            time: 5,
                            position: 'top'
                        });
                    }
                }
            });
        }
    });
});    
$(document).ready(function($) {
    $('#addNewUser').click(function() {
        $('#id').val('');
        $('#userInserUpdateForm').trigger("reset");
        $('#userModel').html("Add New Student");
        $('#user-model').modal('show');
    });
    $('body').on('click', '.edit', function() {
        var id = $(this).data('id');
        // ajax
        $.ajax({
            type: "POST",
            url: base_url + "page/edit_student_action",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(resp) {
                //console.log(resp)
                $('#userModel').html("Edit Student");
                $('#user-model').modal('show');
                $('#id').val(resp.id);
                $('#name').val(resp.name);
                $('#mobile').val(resp.mobile);
                $('#email').val(resp.email);
                $('#class').val(resp.class);
            }
        });
    });
    $('.load-more').click(function(){
        var row = Number($('#row').val());
        var allcount = Number($('#all').val());
        var rowperpage = 5;
        row = row + rowperpage;

        $("#row").val(row);

        $.ajax({
            url: base_url + 'page/student_list',
            type: 'post',
            data: {row:row},
            beforeSend:function(){
                $(".load-more").text("Loading...");
            },
            success: function(response){
                setTimeout(function() {
                    $(".post:last").after(response).show().fadeIn("slow");
                    var rowno = row + rowperpage;
                    if(rowno > allcount){
                        $('.load-more').hide();
                    }else{
                        $(".load-more").text("Load more");
                    }
                }, 2000);
            }
        });
    });
});