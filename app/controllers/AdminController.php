<?php

require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';

class AdminController extends Controller
{
    public function __construct()
    {
        if (session_get('is_login', false) !== true) {
            flash('login_notif', [
                'title' => 'Login Required',
                'text'  => 'You must be logged in to access this page.',
                'icon'  => 'warning',
            ]);

            redirect('login');

            exit;
        }
    }

    private function current_date(): string
    {
        return date('Y-m-d H:i:s');
    }

    /*----- Start Admin Pages Views -----*/
    public function dashboard()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'logs_dashboard', null, 'Accessed logs dashboard');

        $log_model = $this->model('Log_Model');

        // --- Pagination setup ---
        $per_page = 10;
        $current_page = (int)(input('page') ?? 1);
        if ($current_page < 1) $current_page = 1;

        // --- Search filter ---
        $search = trim((string) input('search'));

        // Fetch logs with search
        $all_logs = $log_model->MOD_GET_LOGS($search);

        // Pagination calculations
        $total_logs = count($all_logs);
        $total_pages = (int) ceil($total_logs / $per_page);
        $offset = ($current_page - 1) * $per_page;

        // Slice logs for current page
        $logs = array_slice($all_logs, $offset, $per_page);

        // Prepare data for view
        $data = [
            'title' => 'Dashboard',
            'user' => $current_user,
            'logs' => $logs,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'search' => $search
        ];

        $this->view('includes/header', $data);
        $this->view('admin/dashboard_view', $data);
        $this->view('includes/modals/global_modals', $data);
        $this->view('includes/overlays/loading_overlay');
        $this->view('includes/footer', $data);
    }

    public function households()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'households', null, 'Accessed households page');

        $data = [
            'title' => 'Households',
            'user' => $current_user
        ];

        $this->view('includes/header', $data);
        $this->view('admin/households_view');
        $this->view('includes/modals/global_modals', $data);
        $this->view('includes/overlays/loading_overlay');
        $this->view('includes/footer', $data);
    }

    public function residents()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'residents', null, 'Accessed residents page');

        $data = [
            'title' => 'Residents',
            'user' => $current_user
        ];

        $this->view('includes/header', $data);
        $this->view('admin/residents_view');
        $this->view('includes/modals/global_modals', $data);
        $this->view('includes/overlays/loading_overlay');
        $this->view('includes/footer', $data);
    }

    public function demographics()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'demographics', null, 'Accessed demographics page');

        $data = [
            'title' => 'Demographics',
            'user' => $current_user
        ];

        $this->view('includes/header', $data);
        $this->view('admin/demographics_view');
        $this->view('includes/modals/global_modals', $data);
        $this->view('includes/overlays/loading_overlay');
        $this->view('includes/footer', $data);
    }

    public function housing_and_facilities()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'housing_and_facilities', null, 'Accessed housing & facilities page');

        $data = [
            'title' => 'Housing & Facilities',
            'user' => $current_user
        ];

        $this->view('includes/header', $data);
        $this->view('admin/housing_and_facilities_view');
        $this->view('includes/modals/global_modals', $data);
        $this->view('includes/overlays/loading_overlay');
        $this->view('includes/footer', $data);
    }

    public function livelihood()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'livelihood', null, 'Accessed livelihood page');

        $data = [
            'title' => 'Livelihood',
            'user' => $current_user
        ];

        $this->view('includes/header', $data);
        $this->view('admin/livelihood_view');
        $this->view('includes/modals/global_modals', $data);
        $this->view('includes/overlays/loading_overlay');
        $this->view('includes/footer', $data);
    }

    public function social_sectors()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'social_sectors', null, 'Accessed social sectors page');

        $data = [
            'title' => 'Social Sectors',
            'user' => $current_user
        ];

        $this->view('includes/header', $data);
        $this->view('admin/social_sectors_view');
        $this->view('includes/modals/global_modals', $data);
        $this->view('includes/overlays/loading_overlay');
        $this->view('includes/footer', $data);
    }

    public function health_monitoring()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'health_monitoring', null, 'Accessed health monitoring page');

        $data = [
            'title' => 'Health Monitoring',
            'user' => $current_user
        ];

        $this->view('includes/header', $data);
        $this->view('admin/health_monitoring_view');
        $this->view('includes/modals/global_modals', $data);
        $this->view('includes/overlays/loading_overlay');
        $this->view('includes/footer', $data);
    }

    public function reports()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'reports', null, 'Accessed reports page');

        $data = [
            'title' => 'Reports',
            'user' => $current_user
        ];

        $this->view('includes/header', $data);
        $this->view('admin/reports_view');
        $this->view('includes/modals/global_modals', $data);
        $this->view('includes/overlays/loading_overlay');
        $this->view('includes/footer', $data);
    }

    public function user_management()
    {
        if (session_get('user')['role'] != 'ADMIN') {
            flash('flash_notif', [
                'title' => 'Unauthorized',
                'text'  => 'You are not authorized to access this page.',
                'icon'  => 'error',
            ]);

            redirect('dashboard');
        }

        $current_user = session_get('user', null);
        $user_id = $current_user['id'];

        write_log('ACCESS_PAGE', 'user_management', null, 'Accessed user management page');

        $user_model = $this->model('User_Model');

        // --- Pagination setup ---
        $per_page = 10; // max users per page
        $current_page = (int)(input('page') ?? 1);
        if ($current_page < 1) $current_page = 1;

        // --- Get search filters from URL ---
        $search_input = trim((string) input('search_input'));
        $role = trim((string) input('role'));
        $status = trim((string) input('status'));

        // --- Fetch filtered users ---
        $all_users = $user_model->MOD_SEARCH_USERS($search_input, $role, $status, $user_id);

        // Pagination calculations
        $total_users = count($all_users);
        $total_pages = (int)ceil($total_users / $per_page);
        $offset = ($current_page - 1) * $per_page;

        // Slice users for current page
        $users = array_slice($all_users, $offset, $per_page);

        // --- Prepare data for view ---
        $data = [
            'title' => 'User Management',
            'user' => $current_user,
            'users' => $users,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'search_input' => $search_input,
            'role' => $role,
            'status' => $status
        ];

        // --- Load views ---
        $this->view('includes/header', $data);
        $this->view('admin/user_management_view', $data);
        $this->view('includes/modals/user_management_modals');
        $this->view('includes/modals/global_modals', $data);
        $this->view('includes/overlays/loading_overlay');
        $this->view('includes/footer', $data);
    }

    /*----- End Admin Pages Views -----*/

    public function add_user_account()
    {
        $full_name = trim(input('full_name'));
        $username = trim(input('username'));
        $role = trim(input('role'));
        $is_active = trim(input('is_active'));
        $password = trim(input('password'));

        $response = [
            'success' => true,
            'message' => 'Account added successfully.'
        ];

        $user_model = $this->model('User_Model');

        $username_exists = $user_model->MOD_CHECK_IF_USERNAME_EXISTS($username);

        if ($username_exists) {
            $response['success'] = false;
            $response['error'] = 'Username is already taken.';
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $data = [
                'full_name' => $full_name,
                'username' => $username,
                'role' => $role,
                'is_active' => $is_active,
                'password_hash' => $password_hash,
                'created_at' => $this->current_date()
            ];

            $new_user_id = $user_model->MOD_ADD_USER_ACCOUNT($data);

            // Log user creation
            write_log('ADD_USER', 'users', $new_user_id, "Added new user: $username with role $role");

            flash('flash_notif', [
                'title' => 'Account Created',
                'text' => 'The user account has been successfully added.',
                'icon' => 'success',
            ]);
        }

        return json($response);
    }

    public function update_user_account()
    {
        $user_id = trim(input('user_id'));
        $full_name = trim(input('full_name'));
        $username = trim(input('username'));
        $role = trim(input('role'));

        $response = [
            'success' => true,
            'message' => 'Account updated successfully.'
        ];

        $user_model = $this->model('User_Model');

        $username_exists = $user_model->MOD_CHECK_IF_USERNAME_EXISTS($username, $user_id);

        if ($username_exists) {
            $response['success'] = false;
            $response['error'] = 'Username is already taken.';
        } else {
            $data = [
                'full_name' => $full_name,
                'username' => $username,
                'role' => $role,
                'updated_at' => $this->current_date()
            ];

            $updated_user_id = $user_model->MOD_UPDATE_USER_ACCOUNT($user_id, $data);

            // Log user update
            write_log('UPDATE_USER', 'users', $updated_user_id, "Updated user account: $username with role $role");

            flash('flash_notif', [
                'title' => 'Account Updated',
                'text' => 'The user account has been successfully updated.',
                'icon' => 'success',
            ]);
        }

        return json($response);
    }

    public function disable_user_account()
    {
        $user_id = trim(input('user_id'));
        $username = trim(input('username'));

        $user_model = $this->model('User_Model');

        $data = [
            'is_active'  => 0, // Deactivate account
            'updated_at' => $this->current_date()
        ];

        $updated_user_id = $user_model->MOD_ENABLE_DISABLE_USER_ACCOUNT($user_id, $data);

        if ($updated_user_id) {
            // Log user update
            write_log('UPDATE_USER', 'users', $updated_user_id, "Disabled user account: $username");

            // Flash message for front-end notifications (optional)
            flash('flash_notif', [
                'title' => 'Account Disabled',
                'text'  => "The account for $username has been successfully disabled.",
                'icon'  => 'success',
            ]);

            $response = [
                'success' => true,
                'message' => "The account for $username has been disabled successfully."
            ];
        } else {
            $response = [
                'success' => false,
                'message' => "Failed to disable the account for $username."
            ];
        }

        return json($response);
    }

    public function enable_user_account()
    {
        $user_id = trim(input('user_id'));
        $username = trim(input('username'));

        $user_model = $this->model('User_Model');

        $data = [
            'is_active'  => 1,
            'updated_at' => $this->current_date()
        ];

        $updated_user_id = $user_model->MOD_ENABLE_DISABLE_USER_ACCOUNT($user_id, $data);

        if ($updated_user_id) {
            // Log user update
            write_log('UPDATE_USER', 'users', $updated_user_id, "Enabled user account: $username");

            // Flash message for front-end notifications (optional)
            flash('flash_notif', [
                'title' => 'Account Enabled',
                'text'  => "The account for $username has been successfully enabled.",
                'icon'  => 'success',
            ]);

            $response = [
                'success' => true,
                'message' => "The account for $username has been enabled successfully."
            ];
        } else {
            $response = [
                'success' => false,
                'message' => "Failed to enable the account for $username."
            ];
        }

        return json($response);
    }

    public function update_account()
    {
        $user_id = trim(input('user_id'));
        $full_name = trim(input('full_name'));
        $username = trim(input('username'));
        $current_password = input('current_password');
        $new_password = input('new_password');

        $response = [
            'success' => true,
            'errors' => [],
            'message' => 'Account updated successfully.'
        ];

        $valid = true;

        $user_model = $this->model('User_Model');

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
                'updated_at' => $this->current_date()
            ];

            if ($current_password && $new_password) {
                $data['password_hash'] = password_hash($new_password, PASSWORD_BCRYPT);
            }

            if ($user_model->MOD_UPDATE_ACCOUNT($user_id, $data)) {
                $user = $user_model->MOD_GET_USER_BY_ID($user_id);
                session_set('user', $user);

                // Log account update
                write_log('UPDATE_USER', 'users', $user_id, "Updated account: $username");

                flash('flash_notif', [
                    'title' => 'Update Successful',
                    'text' => 'Your account information has been updated.',
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

    public function export_logs()
    {
        if (!session_get('is_login', false)) {
            redirect('login');
            return;
        }

        if (session_get('user')['role'] !== 'ADMIN') {
            redirect('dashboard');
            return;
        }

        $log_model = $this->model('Log_Model');

        $logs = $log_model->MOD_GET_LOGS_FOR_EXPORT();

        // Log export action
        write_log(
            'EXPORT_LOGS',
            'logs',
            null,
            'System logs were exported by an administrator.'
        );

        $filename = 'system_logs_' . date('Y-m-d_H-i-s') . '.csv';

        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $output = fopen('php://output', 'w');

        // CSV Header
        fputcsv($output, ['User', 'Action', 'Description', 'Date & Time']);

        // CSV Rows
        foreach ($logs as $log) {
            fputcsv($output, [
                $log['full_name'],
                $log['action'],
                $log['description'],
                $log['created_at']
            ]);
        }

        fclose($output);
        exit;
    }

    public function clear_logs()
    {
        $log_model = $this->model('Log_Model');

        $response = [
            'success' => true,
            'message' => 'System logs have been successfully cleared.'
        ];

        if ($log_model->MOD_CLEAR_LOGS()) {
            write_log(
                'CLEAR_LOGS',
                'logs',
                null,
                'All system logs were cleared by an administrator.'
            );

            flash('flash_notif', [
                'title' => 'Logs Cleared',
                'text'  => 'All system logs have been successfully removed.',
                'icon'  => 'success',
            ]);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unable to clear system logs at this time.'
            ];
        }

        return json($response);
    }
}
