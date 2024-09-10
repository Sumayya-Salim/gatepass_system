$(document).ready(function () {
    $("#editparkingForm").validate({
        rules: {
            owner_name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true // Validates format of email
            },
            phoneno: {
                required: true,
                digits: true, // Ensures only digits are entered
                minlength: 10, // Minimum 10 digits for phone number
                maxlength: 10 // Maximum 10 digits for phone number
            },
            password: {
                required: true,
                minlength: 6 // Minimum 6 characters for password
            },
            flat_no: {
                required: true
            },
            members: {
                required: true,
                digits: true // Ensures only numeric values for members
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
        
        submitHandler: function (form) {
            var submitBtn = $("#submitBtn");
            submitBtn.prop("disabled", true).text("Please wait...");

            var formData = new FormData($("#editparkingForm")[0]);

            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: UPDATE_FLATOWNER_URL,
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
                            title: response.message,
                            icon: "warning",
                        });
                        submitBtn.prop("disabled", false).text("Submit");
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: "Something went wrong",
                        icon: "error",
                    });
                    submitBtn.prop("disabled", false).text("Submit");
                },
            });
        },
    });
});
