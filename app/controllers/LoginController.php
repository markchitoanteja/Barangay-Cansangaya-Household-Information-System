<?php

require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';

class LoginController extends Controller
{
    /**
     * Show login page
     */
    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session_get('is_login', false) === true) {
            redirect('dashboard');
            return;
        }

        // Load login view
        $this->view('auth/login');
    }
}
