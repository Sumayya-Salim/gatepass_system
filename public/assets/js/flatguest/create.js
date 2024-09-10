$(document).ready(function () {
    // Add jQuery validation rules for the form
    $("#guestform").validate({
        rules: {  // Add the 'rules' keyword
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
                // Custom rule for comparing times
                greaterThan: "#entry_time"
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
            // Handle OTP request when validation is successful
            $("#sendOtpBtn").trigger("click");
        }
    });

    // Custom validator method to ensure exit_time is greater than entry_time
    $.validator.addMethod("greaterThan", function (value, element, param) {
        var entryTime = $(param).val();
        return new Date(value) > new Date(entryTime);
    }, "Exit time must be later than entry time.");

    $("#sendOtpBtn").on("click", function (e) {
        e.preventDefault(); // Prevent the form from submitting normally

        if ($("#guestform").valid()) {
            // Disable the button to prevent multiple submissions
            $("#sendOtpBtn").attr("disabled", true).text("Sending...");

            // Serialize the form data
            const formData = $("#guestform").serialize();


            // Send the OTP request via AJAX
            $.post(generateOtpUrl, formData, function (response) {
                // Debugging: Log the response from the OTP request
                console.log("OTP Response:", response);

                if (response.success) {
                    // Show success message when OTP is sent
                    Swal.fire({
                        title: "Success",
                        text: "OTP has been sent to the visitor's email.",
                        icon: "success",
                        confirmButtonText: "OK",
                    }).then(() => {
                        // Redirect to the dashboard URL after clicking OK
                        window.location.href = dashboard_url;
                    });
                } else {
                    // Show error message if OTP sending fails
                    Swal.fire("Error", response.message, "error");
                    // Re-enable the button in case of failure
                    $("#sendOtpBtn").attr("disabled", false).text("Send OTP");
                }
            }).fail(function (xhr) {
                // Handle any errors during the OTP request
                console.error("OTP Request Error:", xhr.responseText);
                Swal.fire(
                    "Error",
                    "An error occurred while generating the OTP.",
                    "error"
                );

                // Re-enable the button in case of failure
                $("#sendOtpBtn").attr("disabled", false).text("Send OTP");
            });
        }
    });
});
