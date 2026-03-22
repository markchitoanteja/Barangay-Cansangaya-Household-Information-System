<?php

class AuthController extends Controller
{
    public function index()
    {
        if (session_get('is_login', false) === true) {
            redirect('dashboard');
            return;
        }

        // Log page visit
        write_log('ACCESS_PAGE', 'auth', null, 'Accessed login page');

        $this->view('auth/login_view');
    }

    public function forgot_password()
    {
        if (session_get('is_login', false) === true) {
            redirect('dashboard');
            return;
        }

        if (session_get('is_login', false) === true) {
            redirect('dashboard');
            return;
        }

        // Log page visit
        write_log('ACCESS_PAGE', 'auth', null, 'Accessed forgot password page');

        $this->view('auth/forgot_password_view');
    }

    public function authenticate()
    {
        $username = input('username');
        $password = input('password');
        $role     = input('role');
        $remember = input('remember');

        $user_model = $this->model('User_Model');

        // 🔄 Fetch user by username ONLY (no role restriction here)
        $user = $user_model->MOD_GET_USER_BY_USERNAME($username);

        $response = [
            'success' => false,
            'message' => 'Invalid username or password.'
        ];

        if (!empty($user) && password_verify($password, $user['password_hash'])) {

            // 🔐 Role validation (SUPER_ADMIN bypass)
            if ($user['role'] !== 'SUPER_ADMIN' && $user['role'] !== $role) {
                write_log('LOGIN_FAILED_ROLE_MISMATCH', 'users', $user['id'], 'Role mismatch during login');

                $response['message'] = 'Invalid role selected for this account.';
                return json($response);
            }

            if ($user['is_active']) {

                // ✅ Set session
                session_set('is_login', true);
                session_set('user', $user);

                // ✅ Load security questions
                $security_questions = $user_model->MOD_GET_QUESTIONS_BY_USER_ID((int)$user['id']);
                session_set('security_questions', $security_questions);

                // ✅ Secure remember me (NO PASSWORD STORAGE)
                if ($remember) {
                    $token = bin2hex(random_bytes(32));

                    session_set('remember_me', true);
                    session_set('remember_token', $token);
                    session_set('remember_username', $username);

                    // OPTIONAL (recommended): store token in DB for persistent login
                    // $user_model->STORE_REMEMBER_TOKEN($user['id'], $token);
                } else {
                    session_remove('remember_me');
                    session_remove('remember_token');
                    session_remove('remember_username');
                }

                // ✅ Log success
                write_log('LOGIN_SUCCESS', 'users', $user['id'], 'User logged in successfully');

                flash('flash_notif', [
                    'title' => 'Login Successful',
                    'text'  => 'You have successfully logged in.',
                    'icon'  => 'success',
                ]);

                $response['success'] = true;
                $response['message'] = 'Login successful.';
                $response['security_questions'] = $security_questions;
            } else {
                // 🚫 Inactive account
                write_log('LOGIN_FAILED_INACTIVE', 'users', $user['id'], 'Attempted login on inactive account');

                $response['message'] = 'This account is currently inactive. Please contact the system administrator.';
            }
        } elseif (!empty($user)) {
            // ❌ Wrong password
            write_log('LOGIN_FAILED_WRONG_PASSWORD', 'users', $user['id'], 'Incorrect password attempt');
        }

        return json($response);
    }

    public function validate_username()
    {
        $username = input('username');
        $role = input('role');

        $user_model = $this->model('User_Model');

        $user = $user_model->MOD_GET_USER_BY_USERNAME_AND_ROLE($username, $role);

        if (!empty($user)) {
            if ($user['is_active']) {
                // Log username validation success
                write_log('USERNAME_VALIDATED', 'users', $user['id'], 'Username validated successfully');

                return json([
                    'success' => true,
                    'message' => 'Username is valid.',
                    'data' => [
                        'user_id' => $user['id'],
                    ],
                ]);
            } else {
                // Log inactive user validation attempt
                write_log('USERNAME_VALIDATION_FAILED', 'users', $user['id'], 'Attempted validation on inactive account');

                return json([
                    'success' => false,
                    'message' => 'This account is currently inactive. Please contact the system administrator.',
                ]);
            }
        } else {
            // Log username not found
            write_log('USERNAME_NOT_FOUND', 'users', null, 'Username not found for selected role');

            return json([
                'success' => false,
                'message' => 'Username not found for the selected role.',
            ]);
        }
    }

    public function get_security_questions()
    {
        $user_id = input('user_id');

        $user_model = $this->model('User_Model');

        $questions = $user_model->MOD_GET_QUESTIONS_BY_USER_ID($user_id);

        // Log fetching security questions
        write_log('FETCH_SECURITY_QUESTIONS', 'users', $user_id, 'Retrieved security questions for password recovery');

        return json([
            'success' => true,
            'message' => 'Security questions retrieved successfully.',
            'data' => $questions,
        ]);
    }

    public function verify_security_answers()
    {
        $user_id = (int) input('user_id');
        $answers = json_decode(input('answers'), true);

        if ($user_id <= 0) {
            return json([
                'success' => false,
                'message' => 'Invalid user ID.'
            ]);
        }

        if (!is_array($answers) || empty($answers)) {
            return json([
                'success' => false,
                'message' => 'Security answers are required.'
            ]);
        }

        $user_model = $this->model('User_Model');
        $is_valid = $user_model->MOD_VERIFY_SECURITY_ANSWERS($user_id, $answers);

        if ($is_valid) {
            // Log successful verification
            write_log('SECURITY_ANSWERS_VERIFIED', 'users', $user_id, 'User verified security questions successfully');

            return json([
                'success' => true,
                'message' => 'Security answers verified successfully.',
                'user_id' => $user_id
            ]);
        }

        // Log failed verification
        write_log('SECURITY_ANSWERS_FAILED', 'users', $user_id, 'Incorrect security answers submitted');

        return json([
            'success' => false,
            'message' => 'Incorrect security answers.'
        ]);
    }

    public function reset_password()
    {
        $user_id = (int) input('user_id');
        $password = trim((string) input('password'));
        $password_confirm = trim((string) input('password_confirm'));

        if ($user_id <= 0) {
            return json([
                'success' => false,
                'message' => 'Invalid user ID.'
            ]);
        }

        if ($password === '' || $password_confirm === '') {
            return json([
                'success' => false,
                'message' => 'Please complete all password fields.'
            ]);
        }

        if (strlen($password) < 8) {
            return json([
                'success' => false,
                'message' => 'Password must be at least 8 characters long.'
            ]);
        }

        if ($password !== $password_confirm) {
            return json([
                'success' => false,
                'message' => 'Passwords do not match.'
            ]);
        }

        $user_model = $this->model('User_Model');
        $updated = $user_model->MOD_RESET_PASSWORD($user_id, $password);

        if (!$updated) {
            write_log('PASSWORD_RESET_FAILED', 'users', $user_id, 'Password reset attempt failed');
            return json([
                'success' => false,
                'message' => 'Password reset failed.'
            ]);
        }

        // Log successful password reset
        write_log('PASSWORD_RESET', 'users', $user_id, 'User password has been reset successfully');

        flash('login_notif', [
            'title' => 'Password Reset Successful',
            'text' => 'Your password has been successfully reset.',
            'icon' => 'success',
        ]);

        return json([
            'success' => true,
            'message' => 'You can now log in with your new password.'
        ]);
    }

    public function logout()
    {
        $current_user = session_get('user', null);

        // Log logout
        if ($current_user) {
            write_log('LOGOUT', 'users', $current_user['id'], 'User logged out successfully');
        }

        session_remove('is_login');
        session_remove('user');

        flash('login_notif', [
            'title' => 'Logged out',
            'text' => 'Logged out successfully.',
            'icon' => 'success',
        ]);

        return json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ]);
    }
}
