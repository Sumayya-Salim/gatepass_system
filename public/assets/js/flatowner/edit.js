$(document).ready(function () {
    var submitBtn = $("#updateBtn");
    var originalData = $("#editform").serialize();;

    submitBtn.prop("disabled", true);

    // Function to check if form data has changed
    function checkFormChanges() {
        var currentData = $("#editparkingForm").serialize();
        if (currentData === originalData) {
            submitBtn.prop("disabled", true); // Disable if no changes
        } else {
            submitBtn.prop("disabled", false); // Enable if changes are made
        }
    }

    // Monitor input, change, and keyup events on all form fields
    $("#editparkingForm input, #editparkingForm select").on("input change", function () {
        checkFormChanges();
    });

    // Custom validation for parking slot dropdown
    $.validator.addMethod("validParkSlot", function (value, element) {
        return value !== ""; // Ensure "Select Park Slot" option is not chosen
    }, "Please select a valid parking slot.");

    // Custom validation for owner name
    $.validator.addMethod("validName", function (value, element) {
        return /^\s*[A-Za-z]{3,}[A-Za-z\s\-\']*$/.test(value); 
    }, "Name must have at least 3 letters, and special characters can only come after that.");

    // Initialize form validation
    $("#editparkingForm").validate({
        rules: {
            owner_name: {
                required: true,
                validName: true,
            },
            email: {
                required: true,
                email: true
            },
            phoneno: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            password: {
                required: true,
                minlength: 6
            },
            flat_no: {
                required: true
            },
            members: {
                required: true,
                digits: true
            },
            park_slott: {
                required: true,
                validParkSlot: true // Ensure valid parking slot is selected
            }
        },
        messages: {
            owner_name: {
                required: "Please enter the owner's name.",
                validName: "Name must have at least 3 letters, no special characters allowed initially."
            },
            email: {
                required: "Please enter an email address.",
                email: "Please enter a valid email address."
            },
            phoneno: {
                required: "Please enter a phone number.",
                digits: "Please enter only digits for the phone number.",
                minlength: "Phone number must be exactly 10 digits.",
                maxlength: "Phone number must be exactly 10 digits."
            },
            password: {
                required: "Please enter a password.",
                minlength: "Password must be at least 6 characters long."
            },
            flat_no: {
                required: "Please select a flat number."
            },
            members: {
                required: "Please specify the number of members.",
                digits: "Please enter a valid number of members."
            },
            park_slott: {
                required: "Please select a parking slot.",
                validParkSlot: "Please select a valid parking slot."
            }
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

            var formData = new FormData($("#editparkingForm")[0]);

            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: UPDATE_FLATOWNER_URL,
                data: formData,
                processData: false,
                contentType: false,
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
