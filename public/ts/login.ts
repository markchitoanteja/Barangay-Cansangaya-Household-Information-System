// login.ts (browser-ready)

// Ensure jQuery and Swal are available globally via type definitions

$(function () {
    // Show flash message if available
    if (typeof flashData !== 'undefined' && flashData) {
        showAlert(flashData.title, flashData.text, flashData.icon as "success" | "error" | "warning");
    }

    enableDevOptions(APP_DEBUG);

    // Update year in footer
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
        e.preventDefault();

        const role = ($('input[name="role"]:checked').val() as string) || '';
        const username = ($("#login_username").val() as string).trim();
        const password = ($("#login_password").val() as string).trim();
        const remember = $("#login_remember").is(":checked");

        $("#login_alert").addClass("d-none");

        showLoading();

        const formData = new FormData();
        formData.append('role', role);
        formData.append('username', username);
        formData.append('password', password);
        formData.append('remember', remember ? '1' : '0');

        interface LoginResponse {
            success: boolean;
            message?: string;
        }

        $.ajax({
            url: 'authenticate',
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response: LoginResponse) {
                if (response.success) {
                    location.reload();
                } else {
                    setTimeout(() => {
                        hideLoading();
                        $("#login_alert").removeClass("d-none").html(
                            '<i class="fa-solid fa-triangle-exclamation me-2"></i>' + (response.message ?? "Login failed")
                        );
                    }, 250);
                }
            },
            error: function (xhr) {
                hideLoading();
                console.error(xhr.responseText);
                $("#login_alert").removeClass("d-none").html(
                    '<i class="fa-solid fa-triangle-exclamation me-2"></i>Internal Server Error'
                );
            }
        });
    });

    

    function enableDevOptions(enable: boolean): void {
        if (!enable) {
            $(document).on(
                "contextmenu",
                (e: JQuery.ContextMenuEvent): void => e.preventDefault()
            );

            $(document).on(
                "keydown",
                (e: JQuery.KeyDownEvent): boolean | void => {
                    const key = e.which || e.keyCode;

                    if (key === 123) return false; // F12
                    if (e.ctrlKey && e.shiftKey && [73, 74, 67].includes(key)) return false;
                    if (e.ctrlKey && [85, 83].includes(key)) return false;
                }
            );
        }
    }

    function showLoading() {
        $("#loadingOverlay").removeClass("d-none");
    }

    function hideLoading() {
        $("#loadingOverlay").addClass("d-none");
    }

    function showAlert(title: string, text: string, icon: "success" | "error" | "warning" = "success") {
        Swal.fire({ title, text, icon });
    }
});