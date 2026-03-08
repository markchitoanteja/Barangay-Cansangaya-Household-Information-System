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
        $remember = input('remember');

        $user_model = $this->model('User');

        $user = $user_model->MOD_GET_USER_BY_USERNAME($username);

        $response['message'] = 'Invalid username or password.';

        if (!empty($user) && password_verify($password, $user['password_hash'])) {

            session_set('is_login', true);
            session_set('user', $user);

            if ($remember) {
                session_set('remember_me', true);
            }

            $response['success'] = true;
            $response['message'] = 'Login successful.';
        }

        return json($response);
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
