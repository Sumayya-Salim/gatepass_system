$(document).ready(function () {
    $("#otpverify").on("submit", function (e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Create a FormData object from the form
        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: OTP_VERIFY, // Ensure this is correctly defined
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    // Display success message with Swal
                    Swal.fire({
                        icon: "success",
                        title: "OTP VERIFIED SUCCESSFULLY",
                        timer: 2000, // Display for 2 seconds
                        showConfirmButton: false,
                    }).then(function () {
                        // Redirect to the dashboard URL after Swal is closed
                        window.location.href = dashboard_url;
                    });
                } else {
                    // Display error message if OTP verification fails
                    Swal.fire({
                        title: "Something went wrong",
                        text: response.message,
                        icon: "warning",
                        confirmButtonText: "OK",
                    });
                }
            },
            error: function (xhr) {
                // Display error message for server-side errors
                Swal.fire({
                    icon: "error",
                    title: "An error occurred",
                    text: "Please try again later.",
                });
            },
        });
    });
});
