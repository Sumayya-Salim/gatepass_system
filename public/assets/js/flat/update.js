$(document).ready(function () {
    var submitBtn = $("#updateBtn");
    var originalData = $("#editform").serialize(); // Capture the original form data

    // Initially disable the submit button
    submitBtn.prop("disabled", true);

    // Function to check if the form has changed
    function checkFormChanges() {
        var currentData = $("#editform").serialize(); 
        if (currentData === originalData) {
            submitBtn.prop("disabled", true);
        } else {
            submitBtn.prop("disabled", false);
        }
    }

    // Enable the submit button when any input or select changes
    $("#editform input, #editform select").on("input change", function () {
        checkFormChanges();
    });

    // Custom method to check for valid dropdown selection
    $.validator.addMethod("validOption", function (value, element) {
        return value !== ""; // Ensure a non-empty value is selected
    }, "This field is required.");

    $("#editform").validate({
        rules: {
            flat_no: {
                required: true,
                pattern: /^[0-9]+[A-Za-z]{1}$/, 
            },
            flat_type: {
                required: true,
                validOption: true 
            },
            furniture_type: {
                required: true,
                validOption: true 
            },
        },
        messages: {
            flat_no: {
                required: "Flat Number is required",
                pattern: "Flat Number must be a number followed by an alphabets, no numbers allowed after the alphabets.",
            },
            flat_type: {
                required: "Flat Type is required",
                validOption: "Please select a valid flat type", 
            },
            furniture_type: {
                required: "Furniture Type is required",
                validOption: "Please select a valid furniture type",
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
                    originalData = $("#editform").serialize();
                    submitBtn.prop("disabled", true);
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
