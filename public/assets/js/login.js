$(function () {
    // Footer year
    $("#year").text(new Date().getFullYear());

    // Password toggle
    $("#togglePassword").on("click", function () {
        const $pw = $("#login_password");
        const isPassword = $pw.attr("type") === "password";

        $pw.attr("type", isPassword ? "text" : "password");

        $(this).html(isPassword ? '<i class="fa-regular fa-eye-slash"></i>' : '<i class="fa-regular fa-eye"></i>');
    });

    // Form submission
    $("#login_form").on("submit", function () {
        const role = $('input[name="role"]:checked').val();
        const username = $("#login_username").val().trim();
        const password = $("#login_password").val().trim();
        const remember = $("#login_remember").is(":checked");

        $("#login_alert").addClass("d-none");

        var formData = new FormData();

        formData.append('role', role);
        formData.append('username', username);
        formData.append('password', password);
        formData.append('remember', remember);

        $.ajax({
            url: 'authenticate',
            data: formData,
            type: 'POST',
            // dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                // if (response.success) {
                //     location.reload();
                // } else {
                //     $("#login_alert").removeClass("d-none");
                // }

                console.log(response);
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    });
});