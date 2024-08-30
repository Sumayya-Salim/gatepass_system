$(document).ready(function () {
    var submitBtn = $("#updateBtn");

    // Initially disable the submit button
    submitBtn.prop("disabled", true);

    // Enable the submit button when any input changes
    $("#editform input, #editform select").on("input change", function () {
        submitBtn.prop("disabled", false);
    });

    $("#editform").validate({
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
                required: "Flat number is required",
            },
            flat_type: {
                required: "Please select a flat type",
            },
            furniture_type: {
                required: "Please select a furnish type",
            },
        },
        errorClass: "is-invalid text-danger",
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        success: function (label, element) {
            $(element).removeClass("is-invalid");
            $(label).remove();
        },
        submitHandler: function (form) {
            submitBtn.prop("disabled", true);
            submitBtn.text("Please wait...");

            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                url: UPDATE_FLAT_URL,
                data: formData,
                contentType: false,
                processData: false,
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
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: "Something went wrong",
                        icon: "error",
                    });
                },
                complete: function () {
                    submitBtn.prop("disabled", false);
                    submitBtn.text("UPDATE");
                },
            });
        },
    });
});
