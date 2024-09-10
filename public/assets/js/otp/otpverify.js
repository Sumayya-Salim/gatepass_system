$(document).ready(function () {
    $("#otpverify").validate({
        rules: {
            email: {
                required: true,
                email: true, // Ensures the input is a valid email
            },
            otp: {
                required: true,
                digits: true, // Ensures only digits are allowed
                minlength: 6, // Minimum length of OTP
                maxlength: 6, // Maximum length of OTP
            },
        },
        messages: {
            email: {
                required: "Please enter your email.",
                email: "Please enter a valid email address.",
            },
            otp: {
                required: "Please enter the OTP.",
                digits: "The OTP must be a numeric value.",
                minlength: "The OTP must be exactly 6 digits.",
                maxlength: "The OTP must be exactly 6 digits.",
            },
        },
        errorClass: "is-invalid text-danger",
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.appendTo(element.closest('.form-group').find('.errordiv')); // Ensure errordiv is inside form-group
        },
        success: function (label, element) {
            $(element).removeClass("is-invalid");
            $(label).remove();
        },
        submitHandler: function (form) {
            var submitBtn = $("#submitBtn"); // Adjust button ID as per your form
            submitBtn.prop("disabled", true);
            submitBtn.text("Verifying OTP...");

            var formData = new FormData($("#otpverify")[0]);

            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: OTP_VERIFY, // Replace with your route for OTP verification
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Verified Successfully',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function () {
                            window.location.href = response.dashboard_url; // Adjust redirect as needed
                        });
                    } else {
                        Swal.fire({
                            title: 'OTP Verification Failed',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 400) {
                        Swal.fire({
                            title: 'OTP Incorrect',
                            text: xhr.responseJSON.message,  // Use the server response message
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred',
                            text: 'Please try again later.',
                        });
                    }
                },
                complete: function () {
                    // Re-enable the button and reset text after either success or failure
                    submitBtn.prop("disabled", false);
                    submitBtn.text("Verify OTP");
                }
            });
        }
    });

    // Prevent form from submitting normally
    $("#otpverify").on("submit", function (e) {
        e.preventDefault();
    });
});
