$(document).ready(function () {
    $("#regform").validate({
        rules: {
            flat_no: {
                required: true,
                pattern: /^[0-9]+[A-Za-z]{1}$/, // Number followed by exactly two alphabets, no numbers after alphabets
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
                pattern: "Flat Number must be a number followed by an alphabets, no numbers allowed after the alphabets.",
            },
            flat_type: {
                required: "Flat Type is required",
            },
            furniture_type: {
                required: "Furnish Type is required",
            },
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function (error, element) {
            error.addClass('text-danger');
            element.next('span.invalid-feedback').html(error);
        },
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
                error: function (xhr) {
                    if (xhr.status === 422) { // Laravel validation error
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            var inputField = $("input[name=" + key + "], select[name=" + key + "]");
                            inputField.addClass("is-invalid"); // Add invalid class
                            inputField.next('.invalid-feedback').html(value[0]); // Show error message
                        });
                    } else {
                        Swal.fire({
                            title: "Something went wrong",
                            text: xhr.responseJSON.message || "Please try again later.",
                            icon: "error",
                        });
                    }
                    submitBtn.prop("disabled", false);
                    submitBtn.text("Submit");
                },
            });
        },
    });
});
