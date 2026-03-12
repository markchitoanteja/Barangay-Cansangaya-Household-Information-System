/// <reference types="jquery" />

interface UsernameValidationResponse {
    success: boolean;
    message?: string;
    data?: { user_id: string };
}

interface SecurityQuestionsResponse {
    success: boolean;
    data?: { id: string; question: string }[];
    message?: string;
}

interface VerifyAnswersResponse {
    success: boolean;
    user_id?: string;
    message?: string;
}

interface ResetPasswordResponse {
    success: boolean;
    message?: string;
}

$((): void => {
    enableDevOptions(APP_DEBUG);
    
    $("#year").text(new Date().getFullYear());

    // --- Step 1: Validate username ---
    $("#forgot_step1_form").on("submit", function (e: JQuery.SubmitEvent): void {
        e.preventDefault();
        hideAlert();

        const username = ($("#fp_username").val() as string ?? "").trim();
        const role = ($('input[name="role"]:checked').val() as string ?? "");

        if (!username) return showAlert("Please enter your username.");

        showLoading();

        const formData = new FormData();
        formData.append("username", username);
        formData.append("role", role);

        $.ajax({
            url: "validate-username",
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: formData,
            success: (response: UsernameValidationResponse): void => {
                setTimeout((): void => {
                    hideLoading();

                    if (!response.success) {
                        return showAlert(response.message ?? "Username not found. Please check your input.");
                    }

                    const userId = response.data?.user_id ?? "";
                    if (!userId) return showAlert("Invalid user data.");

                    $("#fp_user_id").val(userId);

                    const questionForm = new FormData();
                    questionForm.append("user_id", userId);

                    $.ajax({
                        url: "get-security-questions",
                        type: "POST",
                        dataType: "JSON",
                        processData: false,
                        contentType: false,
                        data: questionForm,
                        success: (resp: SecurityQuestionsResponse): void => {
                            const $container = $("#security_questions_container").empty();

                            if (resp.success && resp.data && resp.data.length > 0) {
                                resp.data.forEach((q, index) => {
                                    const html = `
                                        <div class="mb-3">
                                            <label for="security_answer_${q.id}" class="form-label">
                                                ${index + 1}. ${q.question}
                                            </label>
                                            <input type="hidden" name="question_ids[]" value="${q.id}">
                                            <input
                                                type="text"
                                                class="form-control security-answer"
                                                id="security_answer_${q.id}"
                                                name="security_answers[]"
                                                data-question-id="${q.id}"
                                                placeholder="Enter your answer"
                                                required
                                            >
                                        </div>
                                    `;
                                    $container.append(html);
                                });
                                goToStep(2);
                            } else {
                                showAlert(resp.message ?? "No security questions found for this account.");
                            }
                        },
                        error: (jqXHR: JQuery.jqXHR, textStatus: string, errorThrown: string): void => {
                            hideLoading();
                            console.error(errorThrown);
                            showAlert("Something went wrong while fetching security questions.");
                        }
                    });
                }, 250);
            },
            error: (jqXHR: JQuery.jqXHR, textStatus: string, errorThrown: string): void => {
                hideLoading();
                console.error(errorThrown);
                showAlert("Something went wrong. Please try again.");
            }
        });
    });

    // --- Step 2: Verify security answers ---
    $("#forgot_step2_form").on("submit", function (e: JQuery.SubmitEvent): void {
        e.preventDefault();
        hideAlert();

        const userId = $("#fp_user_id").val() as string ?? "";
        const answers: { id: string; answer: string }[] = [];

        $(".security-answer").each((index: number, element: HTMLElement): void => {
            const input = element as HTMLInputElement;
            const answer = ($(input).val() as string ?? "").trim().toLowerCase();
            answers.push({ id: $(input).data("question-id") as string, answer });
        });

        if (answers.length === 0) return showAlert("No security questions found.");
        if (answers.some(a => !a.answer)) return showAlert("Please answer all security questions.");

        showLoading();
        const formData = new FormData();
        formData.append("user_id", userId);
        formData.append("answers", JSON.stringify(answers));

        $.ajax({
            url: "verify-security-answers",
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: formData,
            success: (response: VerifyAnswersResponse): void => {
                hideLoading();

                if (!response.success) return showAlert(response.message ?? "Incorrect security answers.");

                $("#fp_verified_user_id").val(response.user_id ?? "");
                goToStep(3);
            },
            error: (jqXHR: JQuery.jqXHR, textStatus: string, errorThrown: string): void => {
                hideLoading();
                console.error(errorThrown);
                showAlert("Something went wrong. Please try again.");
            }
        });
    });

    // --- Step 3: Reset password ---
    $("#forgot_step3_form").on("submit", function (e: JQuery.SubmitEvent): void {
        e.preventDefault();
        hideAlert();

        const userId = $("#fp_verified_user_id").val() as string ?? "";
        const newPassword = ($("#fp_new_password").val() as string ?? "").trim();
        const confirmPassword = ($("#fp_confirm_password").val() as string ?? "").trim();

        if (!userId) return showAlert("Invalid password reset session.");
        if (!newPassword || !confirmPassword) return showAlert("Please complete all password fields.");
        if (newPassword.length < 8) return showAlert("Password must be at least 8 characters long.");
        if (newPassword !== confirmPassword) return showAlert("Passwords do not match.");

        showLoading();
        const formData = new FormData();
        formData.append("user_id", userId);
        formData.append("password", newPassword);
        formData.append("password_confirm", confirmPassword);

        $.ajax({
            url: "reset-password",
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: formData,
            success: (response: ResetPasswordResponse): void => {
                hideLoading();

                if (!response.success) return showAlert(response.message ?? "Password reset failed.");

                Swal.fire({
                    icon: "success",
                    title: "Password Reset Successful",
                    text: response.message ?? "You can now log in with your new password.",
                    confirmButtonText: "Go to Login"
                }).then(() => {
                    window.location.href = BASE_URL + "login";
                });
            },
            error: (jqXHR: JQuery.jqXHR, textStatus: string, errorThrown: string): void => {
                hideLoading();
                console.error(errorThrown);
                showAlert("A server error occurred. Please try again.");
            }
        });
    });

    // --- Back to step 1 ---
    $("#back_to_step1").on("click", (): void => goToStep(1));

    // --- Toggle password visibility ---
    $(document).on("click", ".toggle-password", function (this: HTMLElement): void {
        const target = $(this).data("target") as string ?? "";
        const $input = $(target);
        const $icon = $(this).find("i"); // <-- FIXED

        if ($input.attr("type") === "password") {
            $input.attr("type", "text");
            $icon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            $input.attr("type", "password");
            $icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });

    // --- Helper functions ---
    function showLoading(): void { $("#loadingOverlay").removeClass("d-none"); }
    function hideLoading(): void { $("#loadingOverlay").addClass("d-none"); }
    function showAlert(message: string): void { $("#forgot_alert").removeClass("d-none").html('<i class="fa-solid fa-triangle-exclamation me-2"></i>' + message); }
    function hideAlert(): void { $("#forgot_alert").addClass("d-none").html(''); }
    function goToStep(step: number): void {
        $("#forgot_step1_form, #forgot_step2_form, #forgot_step3_form").addClass("d-none");
        $("#forgot_step" + step + "_form").removeClass("d-none");
        hideAlert();
    }

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
});