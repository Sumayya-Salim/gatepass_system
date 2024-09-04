$(document).ready(function () {
    $("#loginform").validate({

        rules: {
            email: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 6
            },

        },
        messages: {
            email: {
                required: "Please enter email.",

            },
            password: {
                required: "Please enter the password.",
                minlength: "The password must be at least 6 characters long."
            },

        },


        errorClass: "is-invalid text-danger",
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.appendTo(element.closest('.form-group').find('.errordiv'));
        },
        success: function (label, element) {
            $(element).removeClass("is-invalid");
            $(label).remove();
        }, submitHandler: function (form) {
            var submitBtn = $("#submitBtn");
            submitBtn.prop("disabled", true);
            submitBtn.text("Signin");

            var formData = new FormData($("#loginform")[0]);

            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: CARD_LOGIN_URL,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response) {
                        Swal.fire({
                            icon:'success',
                            title:'Login Successful',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function () {
                            window.location.href = REDIRECTED_URL;
                        });
                
                        } else if (response) {
                        Swal.fire({
                            title:'Account Inactive',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } 
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred',
                        text: 'Please try again later.',
                    });
                }
            });
        }
    });
});

