$(document).ready(function () {
    $("#regform").validate({
        rules: {
            flat_no: {
                required: true,
            },
            flat_type: {
                required: true,
            },
            furniture_type: {
                required: true,
            },
        },
        messages: {
            flat_no: {
                required: "Flat Number is required",
            },
            flat_type: {
                required: "Flat Type is required",
            },
            furniture_type: {
                required: "Furnish Type is required",
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
        ignore: [ ],
        submitHandler: function (form) {
            var submitBtn = $("#submitBtn");
            submitBtn.prop("disabled", true);
            submitBtn.text("Please wait...");

            var formData = new FormData($("#regform")[0]);

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
