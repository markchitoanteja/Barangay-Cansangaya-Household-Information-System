<?php

require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';

class LoginController extends Controller
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

    public function authenticate()
    {
        $username = input('username');
        $password = input('password');
        $remember = input('remember');

        $user_model = $this->model('User');

        $user = $user_model->MOD_GET_USER_BY_USERNAME($username);

        $response['message'] = 'Invalid username or password.';

        if (!empty($user) && password_verify($password, $user['password_hash'])) {

            // session_set('is_login', true);
            session_set('user_id', $user['id']);
            session_set('username', $user['username']);
            session_set('role', $user['role']);

            if ($remember) {
                session_set('remember_me', true);
            }

            $response['success'] = true;
            $response['message'] = 'Login successful.';
        }

        return json($response);
    }
}
