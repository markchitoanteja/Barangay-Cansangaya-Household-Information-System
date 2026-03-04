<?php

require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session_get('is_login', false) === true) {
            redirect('login');
            return;
        }

        $data = [
            'title' => 'Dashboard',
            'user' => session_get('user', null)
        ];

        $this->view('includes/header', $data);
        $this->view('admin/dashboard_view');
        $this->view('includes/footer');
    }
}
