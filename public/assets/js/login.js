$(function () {
    if (typeof flashData !== 'undefined' && flashData) {
        showAlert(flashData.title, flashData.text, flashData.icon);
    }

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
                    hideLoading();
                    $("#login_alert").removeClass("d-none").text(response.message);
                }
            },
            error: function (xhr) {
                hideLoading();
                console.error(xhr.responseText);
                $("#login_alert").removeClass("d-none").text("Internal Server Error");
            },
        });
    });

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