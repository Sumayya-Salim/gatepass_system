$(document).ready(function () {
    $("#sendOtpBtn").on("click", function (e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Serialize the form data
        const formData = $("#guestform").serialize();

        // Debugging: Log the serialized form data
        console.log("Form Data:", formData);

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
            }
            }).fail(function (xhr) {
                // Handle any errors during the OTP request
                console.error("OTP Request Error:", xhr.responseText);
                Swal.fire(
                    "Error",
                    "An error occurred while generating the OTP.",
                    "error"
                );
            });
    });
});
