$(document).ready(function () {
    $("#editparkingForm").validate({
        rules: {
            owner_name: {
                required: true,
                minlength: 3
            },
            members: {
                required: true,
            },
            park_slott: {
                required: true
            }
        },
        messages: {
            owner_name: {
                required: "Please enter the owner's name",
                minlength: "Owner's name must be at least 3 characters long"
            },
            members: {
                required: "Please enter the member's name",
            },
            park_slott: {
                required: "Please select a park slot"
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
