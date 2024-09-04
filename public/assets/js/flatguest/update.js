$(function () {
    // Ensure the update button is disabled initially
    $('#updateBtn').prop('disabled', true);

    // Enable the submit button when any input or change event occurs on the form
    $('#guestform').on('input change', function () {
        $('#updateBtn').prop('disabled', false);
    });

    $('#guestform').on('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Create a FormData object from the form
        var formData = new FormData(this);

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
                if (response.success) { // Check if response has success attribute
                    Swal.fire({
                        icon: 'success',
                        title: 'Gatepass updated successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then((result) => {
                        if (result.isConfirmed || result.dismiss) {
                            window.location.href = dashboard_url; // Redirect to dashboard
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
    });
});
