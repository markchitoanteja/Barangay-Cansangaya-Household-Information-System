<?php

class AdminController extends Controller
{
    public function __construct()
    {
        $user_model = $this->model('User_Model');

        // 1️⃣ Check if session exists
        if (session_get('is_login', false) === true) {
            return;
        }

        // 2️⃣ Check remember-me via cookies (FIXED)
        $remember_username = $_COOKIE['remember_username'] ?? null;
        $remember_token    = $_COOKIE['remember_token'] ?? null;

        if ($remember_username && $remember_token) {
            $user = $user_model->MOD_GET_USER_BY_USERNAME($remember_username);

            if (!empty($user) && $user_model->VALIDATE_REMEMBER_TOKEN($user['id'], $remember_token)) {
                // ✅ Restore session
                session_set('is_login', true);
                session_set('user', $user);

                $security_questions = $user_model->MOD_GET_QUESTIONS_BY_USER_ID((int)$user['id']);
                session_set('security_questions', $security_questions);

                write_log('LOGIN_SUCCESS', 'users', $user['id'], 'User auto-logged in via remember token');
                return;
            } else {
                // 🚨 Invalid token → clear cookies
                setcookie('remember_username', '', time() - 3600, '/');
                setcookie('remember_token', '', time() - 3600, '/');
            }
        }

        // 3️⃣ Not authenticated → redirect
        flash('login_notif', [
            'title' => 'Login Required',
            'text'  => 'You must be logged in to access this page.',
            'icon'  => 'warning',
        ]);

        redirect('login');
        exit;
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

        $user_model = $this->model('User_Model');

        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);

        $system_information_model = $this->model('System_Information_Model');

        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        $household_model = $this->model('Household_Model');
        $total_households = count($household_model->MOD_GET_HOUSEHOLDS());

        $Resident_Model = $this->model('Resident_Model');
        $total_residents = count($Resident_Model->MOD_GET_RESIDENTS());

        // Prepare data for view
        $data = [
            'title' => 'Dashboard',
            'user' => $current_user,
            'logs' => $logs,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'search' => $search,
            'security_questions' => $security_questions,
            'total_households' => $total_households,
            'total_residents' => $total_residents,
            'total_beneficiaries' => 0,
            'total_health_records' => 0,
            'system_information' => $system_information
        ];

        $this->view([
            'includes/header',
            'admin/dashboard_view',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function households()
    {
        // ==============================
        // 1. SESSION & ACCESS LOGGING
        // ==============================
        $current_user = session_get('user', null);
        write_log('ACCESS_PAGE', 'households', null, 'Accessed households page');


        // ==============================
        // 2. LOAD MODELS
        // ==============================
        $user_model = $this->model('User_Model');
        $household_model = $this->model('Household_Model');
        $system_information_model = $this->model('System_Information_Model');


        // ==============================
        // 3. FETCH RAW DATA
        // ==============================
        $all_households = $household_model->MOD_GET_HOUSEHOLDS();


        // ==============================
        // 4. GET FILTER INPUTS
        // ==============================
        $search_input = trim((string) input('search_input'));
        $comfort_room = trim((string) input('comfort_room'));
        $water_system = trim((string) input('water_system'));


        // ==============================
        // 5. APPLY FILTERING
        // ==============================
        $filtered_households = array_filter($all_households, function ($h) use ($search_input, $comfort_room, $water_system) {

            $matches_search = empty($search_input)
                || stripos($h['purok'], $search_input) !== false
                || stripos($h['housing_type'], $search_input) !== false;

            $matches_comfort = empty($comfort_room) || $h['comfort_room'] === $comfort_room;
            $matches_water = empty($water_system) || $h['water_system'] === $water_system;

            return $matches_search && $matches_comfort && $matches_water;
        });


        // ==============================
        // 6. PAGINATION
        // ==============================
        $per_page = 10;

        $current_page = (int)(input('page') ?? 1);
        if ($current_page < 1) $current_page = 1;

        $total_households = count($filtered_households);
        $total_pages = (int) ceil($total_households / $per_page);
        $offset = ($current_page - 1) * $per_page;

        $households = array_slice($filtered_households, $offset, $per_page);


        // ==============================
        // 7. FETCH AUXILIARY DATA
        // ==============================
        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);
        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();


        // ==============================
        // 8. PREPARE VIEW DATA
        // ==============================
        $data = [
            'title' => 'Households',
            'user' => $current_user,

            'households' => $households,

            'current_page' => $current_page,
            'total_pages' => $total_pages,

            'search_input' => $search_input,
            'comfort_room' => $comfort_room,
            'water_system' => $water_system,

            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];


        // ==============================
        // 9. LOAD VIEW
        // ==============================
        $this->view([
            'includes/header',
            'admin/households_view',
            'includes/modals/household_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function residents()
    {
        // ==============================
        // 1. SESSION & ACCESS LOGGING
        // ==============================
        $current_user = session_get('user', null);
        write_log('ACCESS_PAGE', 'residents', null, 'Accessed residents page');


        // ==============================
        // 2. LOAD MODELS
        // ==============================
        $user_model = $this->model('User_Model');
        $resident_model = $this->model('Resident_Model');
        $household_model = $this->model('Household_Model');
        $system_information_model = $this->model('System_Information_Model');


        // ==============================
        // 3. FETCH RAW DATA
        // ==============================
        $all_residents = $resident_model->MOD_GET_RESIDENTS();


        // ==============================
        // 4. GET FILTER INPUTS
        // ==============================
        $search_input = trim((string) input('search_input'));
        $sex = trim((string) input('sex'));
        $relationship = trim((string) input('relationship'));


        // ==============================
        // 5. APPLY FILTERING
        // ==============================
        $filtered_residents = array_filter($all_residents, function ($r) use ($search_input, $sex, $relationship) {

            $matches_search = empty($search_input)
                || stripos($r['first_name'], $search_input) !== false
                || stripos($r['last_name'], $search_input) !== false;

            $matches_sex = empty($sex) || $r['sex'] === $sex;
            $matches_relationship = empty($relationship) || $r['relationship'] === $relationship;

            return $matches_search && $matches_sex && $matches_relationship;
        });


        // ==============================
        // 6. PAGINATION
        // ==============================
        $per_page = 10;

        $current_page = (int)(input('page') ?? 1);
        if ($current_page < 1) $current_page = 1;

        $total_residents = count($filtered_residents);
        $total_pages = (int) ceil($total_residents / $per_page);
        $offset = ($current_page - 1) * $per_page;

        $residents = array_slice($filtered_residents, $offset, $per_page);


        // ==============================
        // 7. FETCH AUXILIARY DATA
        // ==============================
        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);
        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        // Extra dataset (specific to residents)
        $households_unfiltered = $household_model->MOD_GET_HOUSEHOLDS_SORT_BY_HOUSEHOLD_CODE();


        // ==============================
        // 8. PREPARE VIEW DATA
        // ==============================
        $data = [
            'title' => 'Residents',
            'user' => $current_user,

            'residents' => $residents,
            'households_unfiltered' => $households_unfiltered,

            'current_page' => $current_page,
            'total_pages' => $total_pages,

            'search_input' => $search_input,
            'sex' => $sex,
            'relationship' => $relationship,

            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];


        // ==============================
        // 9. LOAD VIEW
        // ==============================
        $this->view([
            'includes/header',
            'admin/residents_view',
            'includes/modals/residents_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function demographics()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'demographics', null, 'Accessed demographics page');

        $user_model = $this->model('User_Model');

        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);

        $system_information_model = $this->model('System_Information_Model');

        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        $data = [
            'title' => 'Demographics',
            'user' => $current_user,
            'security_questions' => $security_questions,
            'system_information' => $system_information,
        ];

        $this->view([
            'includes/header',
            'admin/demographics_view',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function housing_and_facilities()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'housing_and_facilities', null, 'Accessed housing & facilities page');

        $user_model = $this->model('User_Model');

        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);

        $system_information_model = $this->model('System_Information_Model');

        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        $data = [
            'title' => 'Housing & Facilities',
            'user' => $current_user,
            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        $this->view([
            'includes/header',
            'admin/housing_and_facilities_view',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function livelihood()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'livelihood', null, 'Accessed livelihood page');

        $user_model = $this->model('User_Model');

        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);

        $system_information_model = $this->model('System_Information_Model');

        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        $data = [
            'title' => 'Livelihood',
            'user' => $current_user,
            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        $this->view([
            'includes/header',
            'admin/livelihood_view',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function social_sectors()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'social_sectors', null, 'Accessed social sectors page');

        $user_model = $this->model('User_Model');

        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);

        $system_information_model = $this->model('System_Information_Model');

        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        $data = [
            'title' => 'Social Sectors',
            'user' => $current_user,
            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        $this->view([
            'includes/header',
            'admin/social_sectors_view',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function health_monitoring()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'health_monitoring', null, 'Accessed health monitoring page');

        $user_model = $this->model('User_Model');

        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);

        $system_information_model = $this->model('System_Information_Model');

        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        $data = [
            'title' => 'Health Monitoring',
            'user' => $current_user,
            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        $this->view([
            'includes/header',
            'admin/health_monitoring_view',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function user_management()
    {
        if (session_get('user')['role'] != 'ADMIN' && session_get('user')['role'] != 'SUPER_ADMIN') {
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

        // --- Fetch security questions for each user ---
        foreach ($all_users as &$user) {
            $user['security_questions'] = $user_model->MOD_GET_QUESTIONS_BY_USER_ID($user['id']);
        }
        unset($user); // break reference

        // Pagination calculations
        $total_users = count($all_users);
        $total_pages = (int)ceil($total_users / $per_page);
        $offset = ($current_page - 1) * $per_page;

        // Slice users for current page
        $users = array_slice($all_users, $offset, $per_page);

        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);

        $system_information_model = $this->model('System_Information_Model');

        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        // --- Prepare data for view ---
        $data = [
            'title' => 'User Management',
            'user' => $current_user,
            'users' => $users,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'search_input' => $search_input,
            'role' => $role,
            'status' => $status,
            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        // --- Load views ---
        $this->view([
            'includes/header',
            'admin/user_management_view',
            'includes/modals/user_management_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    /*----- End Admin Pages Views -----*/

    public function update_security_questions()
    {
        $user_id   = trim(input('user_id'));
        $questions = input('questions'); // array of 3 questions
        $answers   = input('answers');   // array of 3 answers

        $response = ['success' => false, 'message' => 'Failed to update security questions.'];

        if (empty($user_id) || count($questions) !== 3 || count($answers) !== 3) {
            $response['error'] = 'Exactly 3 questions and answers are required.';
            return json($response);
        }

        $user_model = $this->model('User_Model');

        try {
            // Fetch existing questions
            $existing = $user_model->MOD_GET_QUESTIONS_BY_USER_ID((int)$user_id);
            if (count($existing) !== 3) {
                $response['error'] = 'User must already have exactly 3 security questions.';
                return json($response);
            }

            // Map old questions to IDs for update
            $existingMap = array_column($existing, 'id', 'question'); // ['question text' => id]

            // Update each question row with new question and/or answer
            foreach ($questions as $i => $newQuestion) {
                $oldId = array_values($existingMap)[$i]; // get ID of the row to update
                $newAnswer = trim($answers[$i] ?? '');

                $user_model->MOD_UPDATE_SECURITY_QUESTION_BY_ID(
                    (int)$user_id,
                    (int)$oldId,
                    $newQuestion,
                    $newAnswer
                );
            }

            write_log('UPDATE_SECURITY', 'security_questions', (int)$user_id, "Updated security questions for user ID {$user_id}");

            flash('flash_notif', [
                'title' => 'Security Questions Updated',
                'text'  => 'The user\'s security questions have been successfully updated.',
                'icon'  => 'success',
            ]);

            $response['success'] = true;
            $response['message'] = 'Security questions updated successfully.';
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            write_log('ERROR', 'security_questions', (int)$user_id, "Failed to update security questions: " . $e->getMessage());
        }

        return json($response);
    }

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

        // Check if username exists
        $username_exists = $user_model->MOD_CHECK_IF_USERNAME_EXISTS($username);

        if ($username_exists) {
            $response['success'] = false;
            $response['error'] = 'Username is already taken.';
        } else {

            // Hash password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $data = [
                'full_name' => $full_name,
                'username' => $username,
                'role' => $role,
                'is_active' => $is_active,
                'password_hash' => $password_hash,
                'created_at' => $this->current_date()
            ];

            // Add user
            $new_user_id = $user_model->MOD_ADD_USER_ACCOUNT($data);

            // Add random security questions using model
            $questions = $user_model->MOD_GET_RANDOM_SECURITY_QUESTIONS(3);
            $user_model->MOD_INSERT_SECURITY_QUESTIONS($new_user_id, $questions);

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

    public function update_user_account_super_admin_mode()
    {
        $user_id = trim(input('user_id'));
        $full_name = trim(input('full_name'));
        $username = trim(input('username'));
        $role = trim(input('role'));
        $password = trim(input('password'));

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

            // Only update password if not empty
            if (!empty($password)) {
                $data['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
            }

            $updated_user_id = $user_model->MOD_UPDATE_USER_ACCOUNT_SUPER_ADMIN_MODE($user_id, $data);

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

        if (session_get('user')['role'] !== 'ADMIN' && session_get('user')['role'] !== 'SUPER_ADMIN') {
            redirect('dashboard');
            return;
        }

        $log_model = $this->model('Log_Model');

        $logs = $log_model->MOD_GET_LOGS_FOR_EXPORT();

        // Log export action
        write_log('EXPORT_LOGS', 'logs', null, 'System logs were exported by an administrator.');

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

    public function generate_household_code()
    {
        $purok = input('purok', null); // e.g., "Purok 1"

        // Extract purok number
        preg_match('/\d+/', $purok, $matches);
        $purok_number = str_pad($matches[0], 2, '0', STR_PAD_LEFT); // e.g., "01"

        $household_model = $this->model('Household_Model');

        $last_record = $household_model->MOD_GET_LAST_PUROK($purok);

        // Default new number
        $new_number = 1;

        if ($last_record && !empty($last_record['household_code'])) {
            // Extract the numeric part after the dash
            $parts = explode('-', $last_record['household_code']);
            if (isset($parts[1])) {
                $last_number = (int)$parts[1];
                $new_number = $last_number + 1;
            }
        }

        $new_code = "PRK{$purok_number}-" . str_pad($new_number, 4, '0', STR_PAD_LEFT);

        $response = [
            'household_code' => $new_code
        ];

        json($response);
    }

    public function add_household()
    {
        $household_code = input('household_code', null);
        $purok = input('purok', null);
        $address = input('address', null);

        $housing_type = input('housing_type', null);
        $ownership_status = input('ownership_status', null);
        $comfort_room = input('comfort_room', null);
        $water_system = input('water_system', null);
        $electricity_access = input('electricity_access', 1);

        $response = [
            'success' => true,
            'message' => 'Household added successfully.'
        ];

        $data = [
            'household_code' => $household_code,
            'purok' => $purok,
            'address' => $address,

            'housing_type' => $housing_type,
            'ownership_status' => $ownership_status,
            'comfort_room' => $comfort_room,
            'water_system' => $water_system,
            'electricity_access' => $electricity_access,
        ];

        $household_model = $this->model('Household_Model');

        $new_household_id = $household_model->MOD_INSERT_HOUSEHOLD($data);

        // Log household creation
        write_log(
            'ADD_HOUSEHOLD',
            'households',
            $new_household_id,
            "Added new household: $household_code in $purok",
            session_get('user')['id']
        );

        flash('flash_notif', [
            'title' => 'Household Added',
            'text' => 'The household has been successfully added.',
            'icon' => 'success',
        ]);

        json($response);
    }

    public function update_household()
    {
        $id = input('id', null);
        $household_code = input('household_code', null);
        $purok = input('purok', null);
        $address = input('address', null);

        $housing_type = input('housing_type', null);
        $ownership_status = input('ownership_status', null);
        $comfort_room = input('comfort_room', null);
        $water_system = input('water_system', null);
        $electricity_access = input('electricity_access', 1);

        $response = [
            'success' => true,
            'message' => 'Household updated successfully.'
        ];

        $data = [
            'household_code' => $household_code,
            'purok' => $purok,
            'address' => $address,

            'housing_type' => $housing_type,
            'ownership_status' => $ownership_status,
            'comfort_room' => $comfort_room,
            'water_system' => $water_system,
            'electricity_access' => $electricity_access,
        ];

        $household_model = $this->model('Household_Model');

        $updated_household_id = $household_model->MOD_UPDATE_HOUSEHOLD($id, $data);

        // Log household update
        write_log(
            'UPDATE_HOUSEHOLD',
            'households',
            $updated_household_id,
            "Updated household: $household_code in $purok",
            session_get('user')['id']
        );

        flash('flash_notif', [
            'title' => 'Household Updated',
            'text' => 'The household has been successfully updated.',
            'icon' => 'success',
        ]);

        json($response);
    }

    public function add_resident()
    {
        $household_id = input('household_id', null);
        $first_name = input('first_name', null);
        $middle_name = input('middle_name', null);
        $last_name = input('last_name', null);
        $sex = input('sex', null);
        $birthdate = input('birthdate', null);
        $civil_status = input('civil_status', null);
        $relationship = input('relationship', null);

        $response = [
            'success' => true,
            'message' => 'Resident added successfully.'
        ];

        $data = [
            'household_id' => $household_id,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'sex' => $sex,
            'birthdate' => $birthdate,
            'civil_status' => $civil_status,
            'relationship' => $relationship
        ];

        $resident_model = $this->model('Resident_Model');

        $new_resident_id = $resident_model->MOD_INSERT_RESIDENT($data);

        // Log resident creation
        write_log('ADD_RESIDENT', 'residents', $new_resident_id, "Added new resident: $first_name $last_name", session_get('user')['id']);

        flash('flash_notif', [
            'title' => 'Resident Added',
            'text' => 'The resident has been successfully added.',
            'icon' => 'success',
        ]);

        json($response);
    }

    public function edit_resident()
    {
        $id = input('id', null);
        $household_id = input('household_id', null);
        $first_name = input('first_name', null);
        $middle_name = input('middle_name', null);
        $last_name = input('last_name', null);
        $sex = input('sex', null);
        $birthdate = input('birthdate', null);
        $civil_status = input('civil_status', null);
        $relationship = input('relationship', null);

        $response = [
            'success' => true,
            'message' => 'Resident updated successfully.'
        ];

        $data = [
            'household_id' => $household_id,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'sex' => $sex,
            'birthdate' => $birthdate,
            'civil_status' => $civil_status,
            'relationship' => $relationship
        ];

        $resident_model = $this->model('Resident_Model');

        $new_resident_id = $resident_model->MOD_UPDATE_RESIDENT($id, $data);

        // Log resident update
        write_log('UPDATE_RESIDENT', 'residents', $new_resident_id, "Updated resident: $first_name $last_name", session_get('user')['id']);

        flash('flash_notif', [
            'title' => 'Resident Updated',
            'text' => 'The resident has been successfully updated.',
            'icon' => 'success',
        ]);

        json($response);
    }
}
