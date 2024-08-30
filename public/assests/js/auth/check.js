$(document).ready(function () {
    $("form").validate({
        submitHandler: function (form) {
            let formData = $(form).serialize(); // Serialize form data

            $.ajax({
                url: $(form).attr('action'), // The form action route
                type: 'POST',

                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: RESET_MESSAGE_URL,
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        // Email sent successfully
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Error occurred
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            });
            return false; // Prevent the form from submitting normally
        }
    });
});
