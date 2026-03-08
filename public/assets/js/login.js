$(function () {
    if (typeof flashData !== 'undefined' && flashData) {
        showAlert(flashData.title, flashData.text, flashData.icon);
    }

    disableDevOptions();

    $("#year").text(new Date().getFullYear());

    // Password toggle
    $("#togglePassword").on("click", function () {
        const $pw = $("#login_password");
        const isPassword = $pw.attr("type") === "password";

        $pw.attr("type", isPassword ? "text" : "password");

        $(this).html(isPassword
            ? '<i class="fa-regular fa-eye-slash"></i>'
            : '<i class="fa-regular fa-eye"></i>'
        );
    });

    // Form submission
    $("#login_form").on("submit", function (e) {
        const role = $('input[name="role"]:checked').val();
        const username = $("#login_username").val().trim();
        const password = $("#login_password").val().trim();
        const remember = $("#login_remember").is(":checked");

        $("#login_alert").addClass("d-none");

        showLoading();

        const formData = new FormData();

        formData.append('role', role);
        formData.append('username', username);
        formData.append('password', password);
        formData.append('remember', remember ? 1 : 0);

        $.ajax({
            url: 'authenticate',
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    location.reload();
                } else {
                    setTimeout(() => {
                        hideLoading();
                        $("#login_alert").removeClass("d-none").html('<i class="fa-solid fa-triangle-exclamation me-2"></i>' + response.message);
                    }, 250);
                }
            },
            error: function (xhr) {
                hideLoading();
                console.error(xhr.responseText);
                $("#login_alert").removeClass("d-none").html('<i class="fa-solid fa-triangle-exclamation me-2"></i>' + "Internal Server Error");
            },
        });
    });

    function disableDevOptions() {
        // Disable right-click
        $(document).on("contextmenu", function (e) {
            e.preventDefault();
        });

        // Disable key combinations used for DevTools
        $(document).keydown(function (e) {

            // F12
            if (e.keyCode == 123) {
                return false;
            }

            // Ctrl+Shift+I
            if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                return false;
            }

            // Ctrl+Shift+J
            if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                return false;
            }

            // Ctrl+Shift+C
            if (e.ctrlKey && e.shiftKey && e.keyCode == 67) {
                return false;
            }

            // Ctrl+U (View Source)
            if (e.ctrlKey && e.keyCode == 85) {
                return false;
            }

            // Ctrl+S
            if (e.ctrlKey && e.keyCode == 83) {
                return false;
            }

        });
    }

    function showLoading() {
        $("#loadingOverlay").removeClass("d-none");
    }

    function hideLoading() {
        $("#loadingOverlay").addClass("d-none");
    }

    function showAlert(title, text, icon = "success") {
        Swal.fire({
            title: title,
            text: text,
            icon: icon
        });
    }
});