$(function () {
    // Footer year
    $("#year").text(new Date().getFullYear());

    // Password toggle
    $("#togglePassword").on("click", function () {
        const $pw = $("#password");
        const isPassword = $pw.attr("type") === "password";

        $pw.attr("type", isPassword ? "text" : "password");

        $(this).html(isPassword ? '<i class="fa-regular fa-eye-slash"></i>' : '<i class="fa-regular fa-eye"></i>');
    });

    // var formData = new FormData();
    
    // formData.append('', value);
    
    $.ajax({
        url: 'login',
        // data: formData,
        type: 'POST',
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
        },
        error: function(_, _, error) {
            console.error(error);
        }
    });
});