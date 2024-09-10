$(document).ready(function () {
    $.validator.addMethod("validName", function (value, element) {
        // Name can start with whitespace, but must have at least 3 letters followed by optional special characters
        return /^\s*[A-Za-z]{3,}[A-Za-z\s\-\']*$/.test(value); 
    }, "Name must have at least 3 letters, and special characters can only come after that.");    

    $("#parkingForm").validate({
        rules: {
            owner_name: {
                required: true,
                validName: true, 
            },
            email: {
                required: true,
                email: true // Validates format of email
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
                required: "Name is required",
                validName: "Name must have at least 3 letters, no special characters allowed initially."
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
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: "error",
                        });
                    }
                    submitBtn.prop("disabled", false);
                    submitBtn.text("Submit");
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 422) { // Laravel validation error
                        var errors = xhr.responseJSON.errors;

                        // Check if the email error exists
                        if (errors.email) {
                            Swal.fire({
                                title: "Warning",
                                text: errors.email[0], // Display email error specifically
                                icon: "warning",
                            });
                        } else {
                            // If other errors exist, collect all error messages
                            var errorMessage = '';
                            $.each(errors, function (key, value) {
                                errorMessage += value[0] + '<br>'; // Collect all error messages
                            });

                            Swal.fire({
                                title: "Validation Error",
                                html: errorMessage, // Display other error messages in SweetAlert
                                icon: "warning",
                            });
                        }
                    } else {
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
