$(document).ready(function () {
    $.validator.addMethod("validName", function (value, element) {
        // Name can start with whitespace, but must have at least 3 letters followed by optional special characters
        return /^\s*[A-Za-z]{3,}[A-Za-z\s\-\']*$/.test(value); 
    }, "Name must have at least 3 letters, and special characters can only come after that.");
        
    $("#securityregform").validate({
        rules: {
            name: {
                required: true,
                validName: true,  // Custom method for name validation
            },
            email: {
                required: true,
                email: true,
            },
            phoneno: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
            password: {
                required: true,
                minlength: 6,
            },
        },
        messages: {
            name: {
                required: "Name is required",
                validName: "Name must have at least 3 letters, no special characters allowed initially."
            },
            email: {
                required: "Email is required",
                email: "Please enter a valid email address",
            },
            phoneno: {
                required: "Phone number is required",
                digits: "Phone number must contain only digits",
                minlength: "Phone number must be exactly 10 digits long",
                maxlength: "Phone number must be exactly 10 digits long",
            },
            password: {
                required: "Password is required",
                minlength: "Password must be at least 6 characters long",
            },
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
            if (element.is("select")) {
                error.insertAfter(element.closest(".form-group").children('label'));
            } else {
                error.insertAfter(element);
            }
        },
        ignore: [],
        submitHandler: function (form) {
            var submitBtn = $("#submitBtn");
            submitBtn.prop("disabled", true);
            submitBtn.text("Please wait...");

            var formData = new FormData($("#securityregform")[0]);

            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: INDEX_EMPLOYEE_URL,
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
                                window.location.href = dashboard_url;
                            }
                        });
                    } else {
                        Swal.fire({
                            title: response.message,
                            icon: "warning",
                        });
                    }
                    submitBtn.prop("disabled", false);
                    submitBtn.text("Submit");
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: "Something went wrong",
                        icon: "error",
                    });
                    submitBtn.prop("disabled", false);
                    submitBtn.text("Submit");
                },
            });
        },
    });
});
