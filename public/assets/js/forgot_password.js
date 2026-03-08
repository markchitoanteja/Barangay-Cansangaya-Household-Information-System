$(document).ready(function () {
    $('#year').text(new Date().getFullYear());

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

    $('#forgot_step1_form').on('submit', function () {
        hideAlert();

        const username = $('#fp_username').val().trim();
        const role = $('input[name="role"]:checked').val();

        showLoading();

        
    });

    $('#forgot_step2_form').on('submit', function (e) {
        e.preventDefault();
        hideAlert();

        const userId = $('#fp_user_id').val();
        const answers = [];

        $('.security-answer').each(function () {
            answers.push({
                id: $(this).data('question-id'),
                answer: $(this).val().trim()
            });
        });

        if (answers.some(item => !item.answer)) {
            showAlert('Please answer all security questions.');
            return;
        }

        showLoading();

        $.ajax({
            url: BASE_URL + 'forgot-password/verify',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                user_id: userId,
                answers: answers
            }),
            success: function (response) {
                hideLoading();

                if (!response.status) {
                    showAlert(response.message || 'Verification failed.');
                    return;
                }

                $('#fp_verified_user_id').val(response.user_id);
                goToStep(3);
            },
            error: function () {
                hideLoading();
                showAlert('A server error occurred. Please try again.');
            }
        });
    });

    $('#forgot_step3_form').on('submit', function (e) {
        e.preventDefault();
        hideAlert();

        const userId = $('#fp_verified_user_id').val();
        const newPassword = $('#fp_new_password').val();
        const confirmPassword = $('#fp_confirm_password').val();

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

        $.ajax({
            url: BASE_URL + 'forgot-password/reset',
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: userId,
                password: newPassword,
                password_confirm: confirmPassword
            },
            success: function (response) {
                hideLoading();

                if (!response.status) {
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
            error: function () {
                hideLoading();
                showAlert('A server error occurred. Please try again.');
            }
        });
    });

    $('#back_to_step1').on('click', function () {
        goToStep(1);
    });
});