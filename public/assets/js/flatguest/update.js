$(function () {
    // Custom method to compare entry and exit time
    $.validator.addMethod("greaterThan", function (value, element, params) {
        var entryTime = $(params).val();
        return Date.parse(value) > Date.parse(entryTime);
    }, 'Exit time must be later than entry time.');

    // jQuery Validation for the form
    $("#guestform").validate({
        rules: {
            user_id: {
                required: true,
            },
            visitor_name: {
                required: true,
                minlength: 3
            },
            visitor_email: {
                required: true,
                email: true
            },
            visitor_phoneno: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            purpose: {
                required: true,
                minlength: 5
            },
            entry_time: {
                required: true,
            },
            exit_time: {
                required: true,
                greaterThan: "#entry_time" // Compare exit_time with entry_time
            }
        },
        messages: {
            user_id: {
                required: "User ID is required."
            },
            visitor_name: {
                required: "Visitor name is required.",
                minlength: "Visitor name must be at least 3 characters long."
            },
            visitor_email: {
                required: "Email is required.",
                email: "Please enter a valid email address."
            },
            visitor_phoneno: {
                required: "Phone number is required.",
                digits: "Please enter only digits.",
                minlength: "Phone number must be 10 digits long.",
                maxlength: "Phone number must be 10 digits long."
            },
            purpose: {
                required: "Purpose is required.",
                minlength: "Purpose must be at least 5 characters long."
            },
            entry_time: {
                required: "Entry time is required."
            },
            exit_time: {
                required: "Exit time is required.",
                greaterThan: "Exit time must be later than entry time."
            }
        },
        errorClass: "is-invalid text-danger", // Styling for error messages
        validClass: "is-valid", // Styling for valid fields
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element); // Place error message after each field
        },
        submitHandler: function (form) {
            // AJAX form submission logic
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: updateGatepassUrl, // Update Gatepass URL
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Gatepass updated successfully',
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            if (result.isConfirmed || result.dismiss) {
                                window.location.href = dashboard_url;
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Something went wrong',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
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

    // Ensure the update button is disabled initially
    $('#updateBtn').prop('disabled', true);

    // Enable the submit button when any input or change event occurs on the form
    $('#guestform').on('input change', function () {
        $('#updateBtn').prop('disabled', false);
    });
});
