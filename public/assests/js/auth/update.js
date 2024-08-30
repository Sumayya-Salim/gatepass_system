$(document).ready(function () {
    $("#editpasswordform").validate({

        rules: {
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            }

        },
        messages: {
            password: {
                required: "Please enter a password.",
                minlength: "The password must be at least 8 characters long."
            },
            password_confirmation: {
                required: "Please confirm your password.",
                minlength: "The password confirmation must be at least 8 characters long.",
                equalTo: "The password confirmation does not match the password."
            }

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
            submitBtn.text("updated");

            var formData = new FormData($("#editpasswordform")[0]);

            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: UPDATE_PASSWORD_URL,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            title: response.message,
                            icon: "success",
    
    
                        })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = redirectUrl;
                                }
                            });
    
                    } else {
                        Swal.fire({
                            title: response.message,
                            icon: "warning",
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

