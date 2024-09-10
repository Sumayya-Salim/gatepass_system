$(document).ready(function () {
    $("#parkingForm").validate({
        rules: {
            owner_name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            phoneno: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            password: {
                required: true,
                minlength: 6
            },
            flat_no: {
                required: true
            },
            members: {
                required: true,
                digits: true
            },
            park_slott: {
                required: true
            }
        },
        messages: {
            owner_name: {
                required: "Please enter the owner's name.",
                minlength: "Owner's name must be at least 3 characters long."
            },
            email: {
                required: "Please enter an email address.",
                email: "Please enter a valid email address."
            },
            phoneno: {
                required: "Please enter a phone number.",
                digits: "Please enter only digits for the phone number.",
                minlength: "Phone number must be exactly 10 digits.",
                maxlength: "Phone number must be exactly 10 digits."
            },
            password: {
                required: "Please enter a password.",
                minlength: "Password must be at least 6 characters long."
            },
            flat_no: {
                required: "Please select a flat number."
            },
            members: {
                required: "Please specify the number of members.",
                digits: "Please enter a valid number of members."
            },
            park_slott: {
                required: "Please select a parking slot."
            }
        },
        errorClass: "is-invalid text-danger",
        validClass: "is-valid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            element.closest(".form-group").find(".error-label").remove();
        },
        ignore: [],
        submitHandler: function (form) {
            var submitBtn = $("#submitBtn");
            submitBtn.prop("disabled", true);
            submitBtn.text("Please wait...");
        
            var formData = new FormData($("#parkingForm")[0]);
        
            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: CREATE_FLATOWNER_URL,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            title: response.message,
                            icon: "success",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = dashboard_url;
                            }
                        });
                    } else {
                        // Handle specific case for email already registered
                        if (response.message === 'Email already registered') {
                            Swal.fire({
                                title: "Warning",
                                text: response.message,
                                icon: "warning",
                            });
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: response.message,
                                icon: "error",
                            });
                        }
                    }
                    submitBtn.prop("disabled", false);
                    submitBtn.text("Submit");
                },
                error: function (xhr, status, error) {
                    // Handle specific case for email already registered
                    if (xhr.status === 409 && xhr.responseJSON.message === 'Email already registered') {
                        Swal.fire({
                            title: "Warning",
                            text: xhr.responseJSON.message,
                            icon: "warning",
                        });
                    } else {
                        // General error message for other issues
                        Swal.fire({
                            title: "Something went wrong",
                            text: xhr.responseJSON.message || "An unexpected error occurred.",
                            icon: "error",
                        });
                    }
                    submitBtn.prop("disabled", false);
                    submitBtn.text("Submit");
                },
            });
        }
    });
});
