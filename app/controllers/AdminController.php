<?php

require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';

class AdminController extends Controller
{
    protected $response;

    public function __construct()
    {
        $this->response = [
            'success' => false,
            'message' => '',
        ];
    }

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

    public function update_account()
    {
        $user_model = $this->model('User_Model');

        $user_id = trim(input('user_id'));
        $full_name = trim(input('full_name'));
        $username = trim(input('username'));
        $current_password = input('current_password');
        $new_password = input('new_password');

        $response = [
            'success' => true,
            'errors' => [],
            'message' => 'Account updated successfully (demo).'
        ];

        $valid = true;

        // --- Backend username validation ---
        $username_exists = $user_model->MOD_CHECK_IF_USERNAME_EXISTS($username, $user_id);

        if ($username_exists) {
            $valid = false;
            $response['success'] = false;
            $response['errors']['username'] = 'Username is already taken.';
        }

        // --- Backend current password validation ---
        if ($current_password && $new_password) {
            $password_hash = $user_model->MOD_GET_HASHED_PASSWORD_BY_ID($user_id);

            if (!password_verify($current_password, $password_hash)) {
                $valid = false;
                $response['success'] = false;
                $response['errors']['current_password'] = 'Current password is incorrect.';
            }
        }

        if ($valid) {
            $data = [
                'full_name' => $full_name,
                'username' => $username,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($current_password && $new_password) {
                $data['password_hash'] = password_hash($new_password, PASSWORD_BCRYPT);
            }

            if ($user_model->MOD_UPDATE_ACCOUNT($user_id, $data)) {
                $user = $user_model->MOD_GET_USER_BY_ID($user_id);

                session_set('user', $user);

                flash('flash_notif', [
                    'title' => 'Success',
                    'text' => 'Your account information has been successfully updated.',
                    'icon' => 'success',
                ]);
            } else {
                flash('flash_notif', [
                    'title' => 'Notice',
                    'text' => 'No changes were made to your account information.',
                    'icon' => 'info',
                ]);
            }
        }

        return json($response);
    }
}
