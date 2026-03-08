$(document).ready(function () {
    disableDevOptions();

    $('#year').text(new Date().getFullYear());

    $('#forgot_step1_form').on('submit', function (e) {
        e.preventDefault();

        hideAlert();

        const username = $('#fp_username').val().trim();
        const role = $('input[name="role"]:checked').val();

        showLoading();

        var formData = new FormData();
        formData.append('username', username);
        formData.append('role', role);

        $.ajax({
            url: 'validate-username',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                setTimeout(() => {
                    hideLoading();

                    if (response.success) {
                        // store user id from backend
                        $('#fp_user_id').val(response.data.user_id || '');

                        var formData = new FormData();

                        formData.append('user_id', response.data.user_id);

                        $.ajax({
                            url: 'get-security-questions',
                            data: formData,
                            type: 'POST',
                            dataType: 'JSON',
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                if (response.success) {
                                    let securityQuestions = response.data || [];

                                    $('#security_questions_container').html('');

                                    if (securityQuestions.length > 0) {
                                        let html = '';

                                        securityQuestions.forEach((q, index) => {
                                            html += `
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
                                        });

                                        $('#security_questions_container').html(html);

                                        goToStep(2);
                                    } else {
                                        showAlert('No security questions found for this account.');
                                    }
                                }
                            },
                            error: function (_, _, error) {
                                console.error(error);
                            }
                        });

                    } else {
                        showAlert(response.message || 'Username not found. Please check your input.');
                    }
                }, 250);
            },
            error: function (_, _, error) {
                hideLoading();
                console.error(error);
                showAlert('Something went wrong. Please try again.');
            }
        });
    });

    $('#forgot_step2_form').on('submit', function (e) {
        e.preventDefault();
        hideAlert();

        const userId = $('#fp_user_id').val();
        const answers = [];

        $('.security-answer').each(function () {
            answers.push({
                id: $(this).data('question-id'),
                answer: $(this).val().trim().toLowerCase()
            });
        });

        if (answers.length === 0) {
            showAlert('No security questions found.');
            return;
        }

        if (answers.some(item => !item.answer)) {
            showAlert('Please answer all security questions.');
            return;
        }

        showLoading();

        var formData = new FormData();
        formData.append('user_id', userId);
        formData.append('answers', JSON.stringify(answers));

        $.ajax({
            url: 'verify-security-answers',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                hideLoading();

                if (response.success) {
                    $('#fp_verified_user_id').val(response.user_id);
                    goToStep(3);
                } else {
                    showAlert(response.message || 'Incorrect security answers.');
                }
            },
            error: function (_, _, error) {
                hideLoading();
                console.error(error);
                showAlert('Something went wrong. Please try again.');
            }
        });
    });

    $('#forgot_step3_form').on('submit', function (e) {
        e.preventDefault();
        hideAlert();

        const userId = $('#fp_verified_user_id').val();
        const newPassword = $('#fp_new_password').val().trim();
        const confirmPassword = $('#fp_confirm_password').val().trim();

        if (!userId) {
            showAlert('Invalid password reset session. Please verify your security answers again.');
            return;
        }

        if (!newPassword || !confirmPassword) {
            showAlert('Please complete all password fields.');
            return;
        }

        if (newPassword.length < 8) {
            showAlert('Password must be at least 8 characters long.');
            return;
        }

        if (newPassword !== confirmPassword) {
            showAlert('Passwords do not match.');
            return;
        }

        showLoading();

        var formData = new FormData();
        formData.append('user_id', userId);
        formData.append('password', newPassword);
        formData.append('password_confirm', confirmPassword);

        $.ajax({
            url: 'reset-password',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                hideLoading();
                console.log(response);

                if (!response.success) {
                    showAlert(response.message || 'Password reset failed.');
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Password Reset Successful',
                    text: response.message || 'You can now log in with your new password.',
                    confirmButtonText: 'Go to Login'
                }).then(() => {
                    window.location.href = BASE_URL + 'login';
                });
            },
            error: function (_, _, error) {
                hideLoading();
                console.error(error);
                showAlert('A server error occurred. Please try again.');
            }
        });
    });

    $('#back_to_step1').on('click', function () {
        goToStep(1);
    });

    $(document).on('click', '.toggle-password', function () {
        const target = $(this).data('target');
        const $input = $(target);
        const isPassword = $input.attr('type') === 'password';

        $input.attr('type', isPassword ? 'text' : 'password');

        $(this).html(
            isPassword
                ? '<i class="fa-regular fa-eye-slash"></i>'
                : '<i class="fa-regular fa-eye"></i>'
        );
    });

    function showLoading() {
        $('#loadingOverlay').removeClass('d-none');
    }

    function hideLoading() {
        $('#loadingOverlay').addClass('d-none');
    }

    function showAlert(message) {
        $('#forgot_alert').removeClass('d-none').html(
            '<i class="fa-solid fa-triangle-exclamation me-2"></i>' + message
        );
    }

    function hideAlert() {
        $('#forgot_alert').addClass('d-none').html('');
    }

    function goToStep(step) {
        $('#forgot_step1_form, #forgot_step2_form, #forgot_step3_form').addClass('d-none');
        $('#forgot_step' + step + '_form').removeClass('d-none');
        hideAlert();
    }

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
});