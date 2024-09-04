$(document).ready(function () {
    $('#sendOtpBtn').click(function () {
        const visitor_email = $('#visitor_email').val();

        $.ajax({
            url: GENERATE_OTP_URL,
            type: 'POST',
            data: {
                visitor_email: visitor_email,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: function (xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: xhr.responseText,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
