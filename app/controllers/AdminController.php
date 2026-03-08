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
        $this->view('includes/footer', $data);
    }
    
    public function households()
    {
        if (!session_get('is_login', false) === true) {
            redirect('login');
            return;
        }

        $data = [
            'title' => 'Households',
            'user' => session_get('user', null)
        ];

        $this->view('includes/header', $data);
        $this->view('admin/households_view');
        $this->view('includes/footer', $data);
    }
    
    public function residents()
    {
        if (!session_get('is_login', false) === true) {
            redirect('login');
            return;
        }

        $data = [
            'title' => 'Residents',
            'user' => session_get('user', null)
        ];

        $this->view('includes/header', $data);
        $this->view('admin/residents_view');
        $this->view('includes/footer', $data);
    }
    
    public function demographics()
    {
        if (!session_get('is_login', false) === true) {
            redirect('login');
            return;
        }

        $data = [
            'title' => 'Demographics',
            'user' => session_get('user', null)
        ];

        $this->view('includes/header', $data);
        $this->view('admin/demographics_view');
        $this->view('includes/footer', $data);
    }
    
    public function housing_and_facilities()
    {
        if (!session_get('is_login', false) === true) {
            redirect('login');
            return;
        }

        $data = [
            'title' => 'Housing & Facilities',
            'user' => session_get('user', null)
        ];

        $this->view('includes/header', $data);
        $this->view('admin/housing_and_facilities_view');
        $this->view('includes/footer', $data);
    }
    
    public function livelihood()
    {
        if (!session_get('is_login', false) === true) {
            redirect('login');
            return;
        }

        $data = [
            'title' => 'Livelihood',
            'user' => session_get('user', null)
        ];

        $this->view('includes/header', $data);
        $this->view('admin/livelihood_view');
        $this->view('includes/footer', $data);
    }
    
    public function social_sectors()
    {
        if (!session_get('is_login', false) === true) {
            redirect('login');
            return;
        }

        $data = [
            'title' => 'Social Sectors',
            'user' => session_get('user', null)
        ];

        $this->view('includes/header', $data);
        $this->view('admin/social_sectors_view');
        $this->view('includes/footer', $data);
    }
    
    public function health_monitoring()
    {
        if (!session_get('is_login', false) === true) {
            redirect('login');
            return;
        }

        $data = [
            'title' => 'Health Monitoring',
            'user' => session_get('user', null)
        ];

        $this->view('includes/header', $data);
        $this->view('admin/health_monitoring_view');
        $this->view('includes/footer', $data);
    }
    
    public function reports()
    {
        if (!session_get('is_login', false) === true) {
            redirect('login');
            return;
        }

        $data = [
            'title' => 'Reports',
            'user' => session_get('user', null)
        ];

        $this->view('includes/header', $data);
        $this->view('admin/reports_view');
        $this->view('includes/footer', $data);
    }
    
    public function user_management()
    {
        if (!session_get('is_login', false) === true) {
            redirect('login');
            return;
        }

        $data = [
            'title' => 'User Management',
            'user' => session_get('user', null)
        ];

        $this->view('includes/header', $data);
        $this->view('admin/user_management_view');
        $this->view('includes/footer', $data);
    }
}
