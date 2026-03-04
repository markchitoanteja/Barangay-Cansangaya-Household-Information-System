<?php

require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';

class LoginController extends Controller
{
    public function index()
    {
        if (session_get('is_login', false) === true) {
            redirect('dashboard');
            return;
        }

        $this->view('auth/login');
    }

    public function login() {
        return json([
            'success' => true,
            'message' => 'Login successful'
        ]);
    }
}
