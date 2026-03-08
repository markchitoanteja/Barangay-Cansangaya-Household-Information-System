<?php

require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';

class AuthController extends Controller
{
    protected $response;

    public function __construct()
    {
        $this->response = [
            'success' => false,
            'message' => '',
        ];
    }

    public function index()
    {
        if (session_get('is_login', false) === true) {
            redirect('dashboard');
            return;
        }

        $this->view('auth/login_view');
    }

    public function forgot_password()
    {
        if (session_get('is_login', false) === true) {
            redirect('dashboard');
            return;
        }

        $this->view('auth/forgot_password_view');
    }

    public function authenticate()
    {
        $username = input('username');
        $password = input('password');
        $role = input('role');
        $remember = input('remember');

        $user_model = $this->model('User_Model');

        $user = $user_model->MOD_GET_USER_BY_USERNAME_AND_ROLE($username, $role);

        $response['message'] = 'Invalid username or password.';

        if (!empty($user) && password_verify($password, $user['password_hash'])) {

            session_set('is_login', true);
            session_set('user', $user);

            if ($remember) {
                session_set('remember_me', true);
                session_set('remember_username', $username);
                session_set('remember_password', $password);
                session_set('remember_role', $role);
            } else {
                session_remove('remember_me');
                session_remove('remember_username');
                session_remove('remember_password');
                session_remove('remember_role');
            }

            $response['success'] = true;
            $response['message'] = 'Login successful.';
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
            return json([
                'success' => true,
                'message' => 'Username is valid.',
                'data' => [
                    'user_id' => $user['id'],
                ],
            ]);
        } else {
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
            return json([
                'success' => true,
                'message' => 'Security answers verified successfully.',
                'user_id' => $user_id
            ]);
        }

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
            return json([
                'success' => false,
                'message' => 'Password reset failed.'
            ]);
        }

        return json([
            'success' => true,
            'message' => 'You can now log in with your new password.'
        ]);
    }

    public function logout()
    {
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
