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
        $remember_token = $_COOKIE['remember_token'] ?? null;

        if ($remember_username && $remember_token) {
            $user = $user_model->MOD_GET_USER_BY_USERNAME($remember_username);

            if (!empty($user) && $user_model->VALIDATE_REMEMBER_TOKEN($user['id'], $remember_token)) {
                // ✅ Restore session
                session_set('is_login', true);
                session_set('user', $user);

                $security_questions = $user_model->MOD_GET_QUESTIONS_BY_USER_ID((int) $user['id']);
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
            'text' => 'You must be logged in to access this page.',
            'icon' => 'warning',
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

        write_log('ACCESS_PAGE', 'dashboard', null, 'Accessed dashboard');

        $log_model = $this->model('Log_Model');

        // --- Pagination setup ---
        $per_page = 10;
        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

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

        $resident_model = $this->model('Resident_Model');
        $total_residents = count($resident_model->MOD_GET_RESIDENTS());

        $program_model = $this->model('Program_Model');
        $total_programs = count($program_model->MOD_GET_PROGRAMS());

        $beneficiary_model = $this->model('Program_Beneficiary_Model');
        $total_beneficiaries = count($beneficiary_model->MOD_GET_BENEFICIARIES());

        $birth_record_model = $this->model('Birth_Record_Model');
        $total_birth_records = count($birth_record_model->MOD_GET_BIRTH_RECORDS());

        $death_record_model = $this->model('Death_Record_Model');
        $total_death_records = count($death_record_model->MOD_GET_DEATH_RECORDS());

        $migration_record_model = $this->model('Migration_Record_Model');
        $total_migration_in_records = count($migration_record_model->MOD_GET_MIGRATION_IN_RECORDS());
        $total_migration_out_records = count($migration_record_model->MOD_GET_MIGRATION_OUT_RECORDS());

        $socio_economic_model = $this->model('Socio_Economic_Model');

        $gender_data = [
            'male' => count($resident_model->MOD_GET_RESIDENT_BY_SEX('male')),
            'female' => count($resident_model->MOD_GET_RESIDENT_BY_SEX('female'))
        ];

        $resident_status = [
            'active' => count($resident_model->MOD_GET_RESIDENT_BY_STATUS('active')),
            'deceased' => count($resident_model->MOD_GET_RESIDENT_BY_STATUS('deceased')),
            'transferred' => count($resident_model->MOD_GET_RESIDENT_BY_STATUS('transferred'))
        ];

        $employment_data = [
            'employed' => count($socio_economic_model->MOD_GET_RESIDENT_BY_STATUS('Employed')),
            'unemployed' => count($socio_economic_model->MOD_GET_RESIDENT_BY_STATUS('Unemployed')),
            'self_employed' => count($socio_economic_model->MOD_GET_RESIDENT_BY_STATUS('Self-employed')),
            'student' => count($socio_economic_model->MOD_GET_RESIDENT_BY_STATUS('Student')),
            'retired' => count($socio_economic_model->MOD_GET_RESIDENT_BY_STATUS('Retired'))
        ];

        $births = [
            'jan' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(1)),
            'feb' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(2)),
            'mar' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(3)),
            'apr' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(4)),
            'may' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(5)),
            'jun' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(6)),
            'jul' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(7)),
            'aug' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(8)),
            'sep' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(9)),
            'oct' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(10)),
            'nov' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(11)),
            'dec' => count($birth_record_model->MOD_GET_BIRTH_RECORDS_BY_MONTH(12))
        ];

        $deaths = [
            'jan' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(1)),
            'feb' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(2)),
            'mar' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(3)),
            'apr' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(4)),
            'may' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(5)),
            'jun' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(6)),
            'jul' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(7)),
            'aug' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(8)),
            'sep' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(9)),
            'oct' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(10)),
            'nov' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(11)),
            'dec' => count($death_record_model->MOD_GET_DEATH_RECORDS_BY_MONTH(12))
        ];

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
            'total_programs' => $total_programs,
            'total_beneficiaries' => $total_beneficiaries,
            'total_birth_records' => $total_birth_records,
            'total_death_records' => $total_death_records,
            'total_migration_in_records' => $total_migration_in_records,
            'total_migration_out_records' => $total_migration_out_records,
            'gender_data' => $gender_data,
            'resident_status' => $resident_status,
            'employment_data' => $employment_data,
            'births' => $births,
            'deaths' => $deaths,
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

        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

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
            'includes/pagination/pagination',
            'includes/modals/households_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function population_forecast()
    {
        // ==============================
        // 1. SESSION & ACCESS LOGGING
        // ==============================
        $current_user = session_get('user', null);
        write_log('ACCESS_PAGE', 'population_forecast', null, 'Accessed population forecast page');


        // ==============================
        // 2. LOAD MODELS
        // ==============================

        $user_model = $this->model('User_Model');
        $system_information_model = $this->model('System_Information_Model');
        $household_model = $this->model('Household_Model');
        $resident_model = $this->model('Resident_Model');
        $birth_record_model = $this->model('Birth_Record_Model');
        $death_record_model = $this->model('Death_Record_Model');
        $migration_record_model = $this->model('Migration_Record_Model');
        $health_record_model = $this->model('Health_Record_Model');
        $socio_economic_model = $this->model('Socio_Economic_Model');

        $db_data = [
            'total_population' => count($resident_model->MOD_GET_RESIDENTS()),
            'total_households' => count($household_model->MOD_GET_HOUSEHOLDS()),
            'total_birth_records' => count($birth_record_model->MOD_GET_BIRTH_RECORDS()),
            'total_death_records' => count($death_record_model->MOD_GET_DEATH_RECORDS()),
            'total_migration_in_records' => count($migration_record_model->MOD_GET_MIGRATION_IN_RECORDS()),
            'total_migration_out_records' => count($migration_record_model->MOD_GET_MIGRATION_OUT_RECORDS()),
            'total_male' => count($resident_model->MOD_GET_RESIDENT_BY_SEX("Male")),
            'total_female' => count($resident_model->MOD_GET_RESIDENT_BY_SEX("Female")),
            'total_children' => count($resident_model->MOD_GET_CHILDREN()),
            'total_working_age' => count($resident_model->MOD_GET_WORKING_AGE()),
            'total_seniors' => count($resident_model->MOD_GET_SENIORS()),
            'total_employed' => count($socio_economic_model->MOD_GET_RESIDENT_BY_STATUS("Employed")),
            'averageIncome' => $socio_economic_model->MOD_GET_AVERAGE_INCOME(),
            'total_pwd' => count($health_record_model->MOD_GET_PWD()),
            'total_chronic_illness' => count($health_record_model->MOD_GET_CHRONIC_ILLNESS()),
        ];

        // ==============================
        // 7. FETCH AUXILIARY DATA
        // ==============================
        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);
        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();


        // ==============================
        // 8. PREPARE VIEW DATA
        // ==============================
        $data = [
            'title' => 'Population Forecast',
            'user' => $current_user,
            'db_data' => $db_data,
            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];


        // ==============================
        // 9. LOAD VIEW
        // ==============================
        $this->view([
            'includes/header',
            'admin/population_forecast_view',
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

        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

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
            'includes/pagination/pagination',
            'includes/modals/residents_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function socio_economic()
    {
        // ==============================
        // 1. SESSION & ACCESS LOGGING
        // ==============================
        $current_user = session_get('user', null);
        write_log('ACCESS_PAGE', 'socio_economic', null, 'Accessed socio-economic page');


        // ==============================
        // 2. LOAD MODELS
        // ==============================
        $user_model = $this->model('User_Model');
        $socio_economic_model = $this->model('Socio_Economic_Model');
        $resident_model = $this->model('Resident_Model');
        $system_information_model = $this->model('System_Information_Model');


        // ==============================
        // 3. FETCH RAW DATA
        // ==============================
        $all_socio_economic_profiles = $socio_economic_model->MOD_GET_SOCIO_ECONOMIC_PROFILES();
        $residents = $resident_model->MOD_GET_RESIDENTS();
        $residents_selection = $resident_model->MOD_GET_RESIDENTS_SORT_BY_LAST_NAME();


        // ==============================
        // 4. GET FILTER INPUTS
        // ==============================
        $search_input = trim((string) input('search_input'));
        $employment_status = trim((string) input('employment_status'));
        $education_level = trim((string) input('education_level'));


        // ==============================
        // 5. APPLY FILTERING
        // ==============================
        $filtered_socio_economic_profiles = array_filter($all_socio_economic_profiles, function ($h) use ($search_input, $employment_status, $education_level) {

            $matches_search = empty($search_input)
                || stripos($h['last_name'], $search_input) !== false
                || stripos($h['first_name'], $search_input) !== false;

            $matches_employment = empty($employment_status) || $h['employment_status'] === $employment_status;
            $matches_education = empty($education_level) || $h['education_level'] === $education_level;

            return $matches_search && $matches_employment && $matches_education;
        });


        // ==============================
        // 6. PAGINATION
        // ==============================
        $per_page = 10;

        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

        $total_socio_economic_profiles = count($filtered_socio_economic_profiles);
        $total_pages = (int) ceil($total_socio_economic_profiles / $per_page);
        $offset = ($current_page - 1) * $per_page;

        $socio_economic_profiles = array_slice($filtered_socio_economic_profiles, $offset, $per_page);


        // ==============================
        // 7. FETCH AUXILIARY DATA
        // ==============================
        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);
        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();


        // ==============================
        // 8. PREPARE VIEW DATA
        // ==============================
        $data = [
            'title' => 'Socio-Economic Profile',
            'user' => $current_user,

            'socio_economic_profiles' => $socio_economic_profiles,
            'residents' => $residents,
            'residents_selection' => $residents_selection,

            'current_page' => $current_page,
            'total_pages' => $total_pages,

            'search_input' => $search_input,
            'employment_status' => $employment_status,
            'education_level' => $education_level,

            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];


        // ==============================
        // 9. LOAD VIEW
        // ==============================
        $this->view([
            'includes/header',
            'admin/socio_economic_view',
            'includes/pagination/pagination',
            'includes/modals/socio_economic_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function programs()
    {
        // ==============================
        // 1. SESSION & ACCESS LOGGING
        // ==============================
        $current_user = session_get('user', null);
        write_log('ACCESS_PAGE', 'programs', null, 'Accessed programs page');

        // ==============================
        // 2. LOAD MODELS
        // ==============================
        $user_model = $this->model('User_Model');
        $program_model = $this->model('Program_Model');
        $system_information_model = $this->model('System_Information_Model');

        // ==============================
        // 3. FETCH RAW DATA
        // ==============================
        $all_programs = $program_model->MOD_GET_PROGRAMS();

        // ==============================
        // 4. GET FILTER INPUTS
        // ==============================
        $search_input = trim((string) input('search_input'));

        // ==============================
        // 5. APPLY FILTERING
        // ==============================
        $filtered_programs = array_filter($all_programs, function ($program) use ($search_input) {

            $matches_search = empty($search_input) || stripos($program['program_name'], $search_input) !== false;

            return $matches_search;
        });

        // ==============================
        // 6. PAGINATION
        // ==============================
        $per_page = 10;

        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

        $total_programs = count($filtered_programs);
        $total_pages = (int) ceil($total_programs / $per_page);
        $offset = ($current_page - 1) * $per_page;

        $programs = array_slice($filtered_programs, $offset, $per_page);

        // ==============================
        // 7. FETCH AUXILIARY DATA
        // ==============================
        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);
        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        // ==============================
        // 8. PREPARE VIEW DATA
        // ==============================
        $data = [
            'title' => 'Programs',
            'user' => $current_user,

            'programs' => $programs,

            'current_page' => $current_page,
            'total_pages' => $total_pages,

            'search_input' => $search_input,

            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        // ==============================
        // 9. LOAD VIEW
        // ==============================
        $this->view([
            'includes/header',
            'admin/programs_view',
            'includes/pagination/pagination',
            'includes/modals/programs_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function programs_beneficiaries()
    {
        // ==============================
        // 1. SESSION & ACCESS LOGGING
        // ==============================
        $current_user = session_get('user', null);
        write_log('ACCESS_PAGE', 'programs_beneficiaries', null, 'Accessed programs beneficiaries page');

        // ==============================
        // 2. LOAD MODELS
        // ==============================
        $user_model = $this->model('User_Model');
        $program_beneficiary_model = $this->model('Program_Beneficiary_Model');
        $system_information_model = $this->model('System_Information_Model');

        // ==============================
        // 3. FETCH RAW DATA
        // ==============================
        $all_beneficiaries = $program_beneficiary_model->MOD_GET_BENEFICIARIES();
        $all_residents = $program_beneficiary_model->MOD_GET_RESIDENTS();
        $all_programs = $program_beneficiary_model->MOD_GET_PROGRAMS();

        // ==============================
        // 4. GET FILTER INPUTS
        // ==============================
        $search_input = trim((string) input('search_input'));

        // ==============================
        // 5. APPLY FILTERING
        // ==============================
        $filtered_beneficiaries = array_filter($all_beneficiaries, function ($beneficiary) use ($search_input) {
            return empty($search_input)
                || stripos($beneficiary['beneficiary_name'], $search_input) !== false
                || stripos($beneficiary['program_name'], $search_input) !== false;
        });

        // ==============================
        // 6. PAGINATION
        // ==============================
        $per_page = 10;

        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

        $total_beneficiaries = count($filtered_beneficiaries);
        $total_pages = (int) ceil($total_beneficiaries / $per_page);
        $offset = ($current_page - 1) * $per_page;

        $beneficiaries = array_slice($filtered_beneficiaries, $offset, $per_page);

        // ==============================
        // 7. FETCH AUXILIARY DATA
        // ==============================
        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);
        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        // ==============================
        // 8. PREPARE VIEW DATA
        // ==============================
        $data = [
            'title' => 'Programs Beneficiaries',
            'user' => $current_user,

            'beneficiaries' => $beneficiaries,
            'all_residents' => $all_residents,
            'all_programs' => $all_programs,

            'current_page' => $current_page,
            'total_pages' => $total_pages,

            'search_input' => $search_input,

            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        // ==============================
        // 9. LOAD VIEW
        // ==============================
        $this->view([
            'includes/header',
            'admin/programs_beneficiaries_view',
            'includes/pagination/pagination',
            'includes/modals/programs_beneficiaries_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function health_records()
    {
        // ==============================
        // 1. SESSION & ACCESS LOGGING
        // ==============================
        $current_user = session_get('user', null);
        write_log('ACCESS_PAGE', 'health_records', null, 'Accessed health records page');

        // ==============================
        // 2. LOAD MODELS
        // ==============================
        $user_model = $this->model('User_Model');
        $health_record_model = $this->model('Health_Record_Model');
        $system_information_model = $this->model('System_Information_Model');

        // ==============================
        // 3. FETCH RAW DATA
        // ==============================
        $all_health_records = $health_record_model->MOD_GET_HEALTH_RECORDS();
        $all_residents = $health_record_model->MOD_GET_RESIDENTS();

        // ==============================
        // 4. GET FILTER INPUTS
        // ==============================
        $search_input = trim((string) input('search_input'));

        // ==============================
        // 5. APPLY FILTERING
        // ==============================
        $filtered_health_records = array_filter($all_health_records, function ($health_record) use ($search_input) {
            return empty($search_input) || stripos($health_record['resident_name'], $search_input) !== false;
        });

        // ==============================
        // 6. PAGINATION
        // ==============================
        $per_page = 10;

        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

        $total_health_records = count($filtered_health_records);
        $total_pages = (int) ceil($total_health_records / $per_page);
        $offset = ($current_page - 1) * $per_page;

        $health_records = array_slice($filtered_health_records, $offset, $per_page);

        // ==============================
        // 7. FETCH AUXILIARY DATA
        // ==============================
        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);
        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        // ==============================
        // 8. PREPARE VIEW DATA
        // ==============================
        $data = [
            'title' => 'Health Records',
            'user' => $current_user,

            'health_records' => $health_records,
            'all_residents' => $all_residents,

            'current_page' => $current_page,
            'total_pages' => $total_pages,

            'search_input' => $search_input,

            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        // ==============================
        // 9. LOAD VIEW
        // ==============================
        $this->view([
            'includes/header',
            'admin/health_records_view',
            'includes/pagination/pagination',
            'includes/modals/health_records_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function birth_records()
    {
        // ==============================
        // 1. SESSION & ACCESS LOGGING
        // ==============================
        $current_user = session_get('user', null);
        write_log('ACCESS_PAGE', 'birth_records', null, 'Accessed birth records page');

        // ==============================
        // 2. LOAD MODELS
        // ==============================
        $user_model = $this->model('User_Model');
        $birth_record_model = $this->model('Birth_Record_Model');
        $system_information_model = $this->model('System_Information_Model');

        // ==============================
        // 3. FETCH RAW DATA
        // ==============================
        $all_birth_records = $birth_record_model->MOD_GET_BIRTH_RECORDS();
        $all_residents = $birth_record_model->MOD_GET_RESIDENTS();

        // ==============================
        // 4. GET FILTER INPUTS
        // ==============================
        $search_input = trim((string) input('search_input'));

        // ==============================
        // 5. APPLY FILTERING
        // ==============================
        $filtered_birth_records = array_filter($all_birth_records, function ($birth_record) use ($search_input) {
            return empty($search_input)
                || stripos($birth_record['child_name'], $search_input) !== false
                || stripos($birth_record['mother_name'], $search_input) !== false;
        });

        // ==============================
        // 6. PAGINATION
        // ==============================
        $per_page = 10;

        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

        $total_beneficiaries = count($filtered_birth_records);
        $total_pages = (int) ceil($total_beneficiaries / $per_page);
        $offset = ($current_page - 1) * $per_page;

        $birth_records = array_slice($filtered_birth_records, $offset, $per_page);

        // ==============================
        // 7. FETCH AUXILIARY DATA
        // ==============================
        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);
        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        // ==============================
        // 8. PREPARE VIEW DATA
        // ==============================
        $data = [
            'title' => 'Birth Records',
            'user' => $current_user,

            'birth_records' => $birth_records,
            'all_residents' => $all_residents,

            'current_page' => $current_page,
            'total_pages' => $total_pages,

            'search_input' => $search_input,

            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        // ==============================
        // 9. LOAD VIEW
        // ==============================
        $this->view([
            'includes/header',
            'admin/birth_records_view',
            'includes/pagination/pagination',
            'includes/modals/birth_records_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function migration_records()
    {
        // ==============================
        // 1. SESSION & ACCESS LOGGING
        // ==============================
        $current_user = session_get('user', null);
        write_log('ACCESS_PAGE', 'migration_records', null, 'Accessed migration records page');

        // ==============================
        // 2. LOAD MODELS
        // ==============================
        $user_model = $this->model('User_Model');
        $migration_record_model = $this->model('Migration_Record_Model');
        $system_information_model = $this->model('System_Information_Model');

        // ==============================
        // 3. FETCH RAW DATA
        // ==============================
        $all_migration_records = $migration_record_model->MOD_GET_MIGRATION_RECORDS();
        $all_residents = $migration_record_model->MOD_GET_RESIDENTS();

        // ==============================
        // 4. GET FILTER INPUTS
        // ==============================
        $search_input = trim((string) input('search_input'));

        // ==============================
        // 5. APPLY FILTERING
        // ==============================
        $filtered_migration_records = array_filter($all_migration_records, function ($migration_record) use ($search_input) {
            return empty($search_input)
                || stripos($migration_record['resident_name'], $search_input) !== false;
        });

        // ==============================
        // 6. PAGINATION
        // ==============================
        $per_page = 10;

        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

        $total_records = count($filtered_migration_records);
        $total_pages = (int) ceil($total_records / $per_page);
        $offset = ($current_page - 1) * $per_page;

        $migration_records = array_slice($filtered_migration_records, $offset, $per_page);

        // ==============================
        // 7. FETCH AUXILIARY DATA
        // ==============================
        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);
        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        // ==============================
        // 8. PREPARE VIEW DATA
        // ==============================
        $data = [
            'title' => 'Migration Records',
            'user' => $current_user,

            'migration_records' => $migration_records,
            'all_residents' => $all_residents,

            'current_page' => $current_page,
            'total_pages' => $total_pages,

            'search_input' => $search_input,

            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        // ==============================
        // 9. LOAD VIEW
        // ==============================
        $this->view([
            'includes/header',
            'admin/migration_records_view',
            'includes/pagination/pagination',
            'includes/modals/migration_records_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function death_records()
    {
        // ==============================
        // 1. SESSION & ACCESS LOGGING
        // ==============================
        $current_user = session_get('user', null);
        write_log('ACCESS_PAGE', 'death_records', null, 'Accessed death records page');

        // ==============================
        // 2. LOAD MODELS
        // ==============================
        $user_model = $this->model('User_Model');
        $death_record_model = $this->model('Death_Record_Model');
        $system_information_model = $this->model('System_Information_Model');

        // ==============================
        // 3. FETCH RAW DATA
        // ==============================
        $all_death_records = $death_record_model->MOD_GET_DEATH_RECORDS();
        $all_residents = $death_record_model->MOD_GET_RESIDENTS();

        // ==============================
        // 4. GET FILTER INPUTS
        // ==============================
        $search_input = trim((string) input('search_input'));

        // ==============================
        // 5. APPLY FILTERING
        // ==============================
        $filtered_death_records = array_filter($all_death_records, function ($death_record) use ($search_input) {
            return empty($search_input)
                || stripos($death_record['resident_name'], $search_input) !== false;
        });

        // ==============================
        // 6. PAGINATION
        // ==============================
        $per_page = 10;

        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

        $total_records = count($filtered_death_records);
        $total_pages = (int) ceil($total_records / $per_page);
        $offset = ($current_page - 1) * $per_page;

        $death_records = array_slice($filtered_death_records, $offset, $per_page);

        // ==============================
        // 7. FETCH AUXILIARY DATA
        // ==============================
        $security_questions = $user_model->MOD_GET_QUESTIONS_BY_ID($current_user['id']);
        $system_information = $system_information_model->MOD_GET_SYSTEM_INFORMATION();

        // ==============================
        // 8. PREPARE VIEW DATA
        // ==============================
        $data = [
            'title' => 'Death Records',
            'user' => $current_user,

            'death_records' => $death_records,
            'all_residents' => $all_residents,

            'current_page' => $current_page,
            'total_pages' => $total_pages,

            'search_input' => $search_input,

            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        // ==============================
        // 9. LOAD VIEW
        // ==============================
        $this->view([
            'includes/header',
            'admin/death_records_view',
            'includes/pagination/pagination',
            'includes/modals/death_records_modals',
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
                'text' => 'You are not authorized to access this page.',
                'icon' => 'error',
            ]);

            redirect('dashboard');
        }

        $current_user = session_get('user', null);
        $user_id = $current_user['id'];

        write_log('ACCESS_PAGE', 'user_management', null, 'Accessed user management page');

        $user_model = $this->model('User_Model');

        // --- Pagination setup ---
        $per_page = 10; // max users per page
        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

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
        $total_pages = (int) ceil($total_users / $per_page);
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
            'includes/pagination/pagination',
            'includes/modals/user_management_modals',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    public function system_logs()
    {
        $current_user = session_get('user', null);

        write_log('ACCESS_PAGE', 'system_logs', null, 'Accessed system logs');

        $log_model = $this->model('Log_Model');

        // --- Pagination setup ---
        $per_page = 10;
        $current_page = (int) (input('page') ?? 1);
        if ($current_page < 1)
            $current_page = 1;

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

        // Prepare data for view
        $data = [
            'title' => 'System Logs',
            'user' => $current_user,
            'logs' => $logs,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'search' => $search,
            'security_questions' => $security_questions,
            'system_information' => $system_information
        ];

        $this->view([
            'includes/header',
            'admin/system_logs_view',
            'includes/pagination/pagination',
            'includes/modals/global_modals',
            'includes/overlays/loading_overlay',
            'includes/footer'
        ], $data);
    }

    /*----- End Admin Pages Views -----*/

    public function update_security_questions()
    {
        $user_id = trim(input('user_id'));
        $questions = input('questions'); // array of 3 questions
        $answers = input('answers');   // array of 3 answers

        $response = ['success' => false, 'message' => 'Failed to update security questions.'];

        if (empty($user_id) || count($questions) !== 3 || count($answers) !== 3) {
            $response['error'] = 'Exactly 3 questions and answers are required.';
            return json($response);
        }

        $user_model = $this->model('User_Model');

        try {
            // Fetch existing questions
            $existing = $user_model->MOD_GET_QUESTIONS_BY_USER_ID((int) $user_id);
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
                    (int) $user_id,
                    (int) $oldId,
                    $newQuestion,
                    $newAnswer
                );
            }

            write_log('UPDATE_SECURITY', 'security_questions', (int) $user_id, "Updated security questions for user ID {$user_id}");

            flash('flash_notif', [
                'title' => 'Security Questions Updated',
                'text' => 'The user\'s security questions have been successfully updated.',
                'icon' => 'success',
            ]);

            $response['success'] = true;
            $response['message'] = 'Security questions updated successfully.';
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            write_log('ERROR', 'security_questions', (int) $user_id, "Failed to update security questions: " . $e->getMessage());
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
            'is_active' => 0, // Deactivate account
            'updated_at' => $this->current_date()
        ];

        $updated_user_id = $user_model->MOD_ENABLE_DISABLE_USER_ACCOUNT($user_id, $data);

        if ($updated_user_id) {
            // Log user update
            write_log('UPDATE_USER', 'users', $updated_user_id, "Disabled user account: $username");

            // Flash message for front-end notifications (optional)
            flash('flash_notif', [
                'title' => 'Account Disabled',
                'text' => "The account for $username has been successfully disabled.",
                'icon' => 'success',
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
            'is_active' => 1,
            'updated_at' => $this->current_date()
        ];

        $updated_user_id = $user_model->MOD_ENABLE_DISABLE_USER_ACCOUNT($user_id, $data);

        if ($updated_user_id) {
            // Log user update
            write_log('UPDATE_USER', 'users', $updated_user_id, "Enabled user account: $username");

            // Flash message for front-end notifications (optional)
            flash('flash_notif', [
                'title' => 'Account Enabled',
                'text' => "The account for $username has been successfully enabled.",
                'icon' => 'success',
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
                'text' => 'All system logs have been successfully removed.',
                'icon' => 'success',
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
                $last_number = (int) $parts[1];
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
        $status = 'Active'; // Default status for new residents

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
            'relationship' => $relationship,
            'status' => $status,
            'created_at' => $this->current_date()
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
        $status = input('status', null);

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
            'relationship' => $relationship,
            'status' => $status,
            'updated_at' => $this->current_date()
        ];

        $resident_model = $this->model('Resident_Model');

        $new_resident_id = $resident_model->MOD_UPDATE_RESIDENT($id, $data);

        if ($resident_model->MOD_CHECK_IF_BIRTH_RECORD_EXISTS($id)) {
            $child_data = [
                'date_of_birth' => $birthdate,
                'sex' => $sex
            ];

            $resident_model->MOD_UPDATE_BIRTH_RECORD_DATE_OF_BIRTH_AND_SEX($id, $child_data);
        }

        // Log resident update
        write_log('UPDATE_RESIDENT', 'residents', $new_resident_id, "Updated resident: $first_name $last_name", session_get('user')['id']);

        flash('flash_notif', [
            'title' => 'Resident Updated',
            'text' => 'The resident has been successfully updated.',
            'icon' => 'success',
        ]);

        json($response);
    }

    public function add_socio_economic_profile()
    {
        $resident_id = input('resident_id', null);
        $occupation = input('occupation', null);
        $employment_status = input('employment_status', null);
        $monthly_income = input('monthly_income', null);
        $education_level = input('education_level', null);
        $literacy_status = input('literacy_status', null); // FIXED name

        $socio_economic_model = $this->model('Socio_Economic_Model');

        // 🔍 CHECK IF ALREADY EXISTS
        $existing = $socio_economic_model->GET_BY_RESIDENT_ID($resident_id);

        if ($existing) {
            return json([
                'success' => false,
                'error' => 'This resident already has a socio-economic profile.'
            ]);
        }

        $data = [
            'resident_id' => $resident_id,
            'occupation' => $occupation,
            'employment_status' => $employment_status,
            'monthly_income' => $monthly_income,
            'education_level' => $education_level,
            'is_literate' => $literacy_status
        ];

        $new_socio_economic_id = $socio_economic_model->MOD_INSERT_SOCIO_ECONOMIC_PROFILE($data);

        // Log
        write_log(
            'ADD_SOCIO_ECONOMIC_PROFILE',
            'socio_economic_profiles',
            $new_socio_economic_id,
            "Added new socio-economic profile for resident: $resident_id",
            session_get('user')['id']
        );

        flash('flash_notif', [
            'title' => 'Socio-economic Profile Added',
            'text' => 'The socio-economic profile has been successfully added.',
            'icon' => 'success',
        ]);

        return json([
            'success' => true,
            'message' => 'Socio-economic profile added successfully.'
        ]);
    }

    public function edit_socio_economic_profile()
    {
        $id = input('id', null);
        $resident_id = input('resident_id', null);
        $occupation = input('occupation', null);
        $employment_status = input('employment_status', null);
        $monthly_income = input('monthly_income', null);
        $education_level = input('education_level', null);
        $literacy_status = input('literacy_status', null); // FIXED name

        $socio_economic_model = $this->model('Socio_Economic_Model');

        $data = [
            'resident_id' => $resident_id,
            'occupation' => $occupation,
            'employment_status' => $employment_status,
            'monthly_income' => $monthly_income,
            'education_level' => $education_level,
            'is_literate' => $literacy_status
        ];

        $socio_economic_model->MOD_UPDATE_SOCIO_ECONOMIC_PROFILE($id, $data);

        // Log
        write_log(
            'UPDATE_SOCIO_ECONOMIC_PROFILE',
            'socio_economic_profiles',
            $id,
            "Updated socio-economic profile for resident: $resident_id",
            session_get('user')['id']
        );

        flash('flash_notif', [
            'title' => 'Socio-economic Profile Updated',
            'text' => 'The socio-economic profile has been successfully updated.',
            'icon' => 'success',
        ]);

        return json([
            'success' => true,
            'message' => 'Socio-economic profile updated successfully.'
        ]);
    }

    public function add_program()
    {
        $program_name = input('program_name', null);
        $description = input('description', null);

        $program_model = $this->model('Program_Model');

        $data = [
            'program_name' => $program_name,
            'description' => $description
        ];

        $new_program_id = $program_model->MOD_INSERT_PROGRAM($data);

        // Log
        write_log(
            'ADD_PROGRAM',
            'programs',
            $new_program_id,
            "Added new program: $program_name",
            session_get('user')['id']
        );

        flash('flash_notif', [
            'title' => 'Program Added',
            'text' => 'The program has been successfully added.',
            'icon' => 'success',
        ]);

        return json([
            'success' => true,
            'message' => 'Program added successfully.'
        ]);
    }

    public function edit_program()
    {
        $id = input('id', null);
        $program_name = input('program_name', null);
        $description = input('description', null);

        $program_model = $this->model('Program_Model');

        $data = [
            'program_name' => $program_name,
            'description' => $description
        ];

        $program_model->MOD_UPDATE_PROGRAM($id, $data);

        // Log
        write_log(
            'EDIT_PROGRAM',
            'programs',
            $id,
            "Edited program: $program_name",
            session_get('user')['id']
        );

        flash('flash_notif', [
            'title' => 'Program Updated',
            'text' => 'The program has been successfully updated.',
            'icon' => 'success',
        ]);

        return json([
            'success' => true,
            'message' => 'Program updated successfully.'
        ]);
    }

    public function add_program_beneficiary()
    {
        $program_id = input('program_id', null);
        $resident_id = input('resident_id', null);
        $status = input('status', null);

        $program_beneficiary_model = $this->model('Program_Beneficiary_Model');

        $data = [
            'program_id' => $program_id,
            'resident_id' => $resident_id,
            'status' => $status,
            'date_enrolled' => $this->current_date()
        ];

        if ($program_beneficiary_model->MOD_CHECK_IF_BENEFICIARY_EXISTS($program_id, $resident_id)) {
            flash('flash_notif', [
                'title' => 'Duplicate Enrollment',
                'text' => 'This resident is already enrolled in the selected program.',
                'icon' => 'error',
            ]);

            return json([
                'success' => true,
                'error' => 'This resident is already enrolled in the selected program.'
            ]);
        } else {
            $new_program_beneficiary_id = $program_beneficiary_model->MOD_INSERT_PROGRAM_BENEFICIARY($data);

            // Log
            write_log(
                'ADD_PROGRAM_BENEFICIARY',
                'program_beneficiaries',
                $new_program_beneficiary_id,
                "Added new program beneficiary: $program_id - $resident_id",
                session_get('user')['id']
            );

            flash('flash_notif', [
                'title' => 'Program Beneficiary Added',
                'text' => 'The program beneficiary has been successfully added.',
                'icon' => 'success',
            ]);

            return json([
                'success' => true,
                'message' => 'Program beneficiary added successfully.'
            ]);
        }
    }

    public function update_beneficiary()
    {
        $id = input('id', null);
        $program_id = input('program_id', null);
        $resident_id = input('resident_id', null);
        $status = input('status', null);

        $program_beneficiary_model = $this->model('Program_Beneficiary_Model');

        $data = [
            'program_id' => $program_id,
            'resident_id' => $resident_id,
            'status' => $status
        ];

        if ($program_beneficiary_model->MOD_CHECK_IF_BENEFICIARY_EXISTS_EXCEPT_CURRENT($id, $program_id, $resident_id)) {
            flash('flash_notif', [
                'title' => 'Duplicate Enrollment',
                'text' => 'This resident is already enrolled in the selected program.',
                'icon' => 'error',
            ]);

            return json([
                'success' => true,
                'error' => 'This resident is already enrolled in the selected program.'
            ]);
        } else {
            $update_success = $program_beneficiary_model->MOD_UPDATE_BENEFICIARY($id, $data);

            if ($update_success) {
                // Log
                write_log(
                    'UPDATE_PROGRAM_BENEFICIARY',
                    'program_beneficiaries',
                    $id,
                    "Updated program beneficiary: $program_id - $resident_id",
                    session_get('user')['id']
                );

                flash('flash_notif', [
                    'title' => 'Program Beneficiary Updated',
                    'text' => 'The program beneficiary has been successfully updated.',
                    'icon' => 'success',
                ]);

                return json([
                    'success' => true,
                    'message' => 'Program beneficiary updated successfully.'
                ]);
            } else {
                flash('flash_notif', [
                    'title' => 'Update Failed',
                    'text' => 'Failed to update the program beneficiary.',
                    'icon' => 'error',
                ]);

                return json([
                    'success' => true,
                    'message' => 'Failed to update the program beneficiary.'
                ]);
            }

        }
    }

    public function add_health_record()
    {
        $resident_id = input('resident_id', null);
        $is_pwd = input('is_pwd', null);
        $is_senior = input('is_senior', null);
        $vaccinated = input('vaccinated', null);
        $blood_type = input('blood_type', null);
        $has_chronic_illness = input('has_chronic_illness', null);
        $chronic_illness_details = input('chronic_illness_details', null);

        $health_record_model = $this->model('Health_Record_Model');

        $data = [
            'resident_id' => $resident_id,
            'is_pwd' => $is_pwd,
            'is_senior' => $is_senior,
            'vaccinated' => $vaccinated,
            'blood_type' => $blood_type,
            'has_chronic_illness' => $has_chronic_illness,
            'chronic_illness_details' => $chronic_illness_details
        ];

        if (!$health_record_model->MOD_CHECK_IF_RESIDENT_EXISTS($resident_id)) {
            $new_health_record_id = $health_record_model->MOD_INSERT_HEALTH_RECORD($data);

            // Log
            write_log(
                'ADD_HEALTH_RECORD',
                'health_records',
                $new_health_record_id,
                "Added new health record for resident: $resident_id",
                session_get('user')['id']
            );

            flash('flash_notif', [
                'title' => 'Health Record Added',
                'text' => 'The health record has been successfully added.',
                'icon' => 'success',
            ]);
        } else {
            flash('flash_notif', [
                'title' => 'Health Record Exists',
                'text' => 'The health record already exists for this resident.',
                'icon' => 'error',
            ]);
        }

        return json([
            'success' => true,
            'message' => 'Health record added successfully.'
        ]);
    }

    public function edit_health_record()
    {
        $id = input('id', null);
        $resident_id = input('resident_id', null);
        $is_pwd = input('is_pwd', null);
        $is_senior = input('is_senior', null);
        $vaccinated = input('vaccinated', null);
        $blood_type = input('blood_type', null);
        $has_chronic_illness = input('has_chronic_illness', null);
        $chronic_illness_details = input('chronic_illness_details', null);

        $health_record_model = $this->model('Health_Record_Model');

        $data = [
            'resident_id' => $resident_id,
            'is_pwd' => $is_pwd,
            'is_senior' => $is_senior,
            'vaccinated' => $vaccinated,
            'blood_type' => $blood_type,
            'has_chronic_illness' => $has_chronic_illness,
            'chronic_illness_details' => $chronic_illness_details,
            'updated_at' => $this->current_date()
        ];

        if (!$health_record_model->MOD_CHECK_IF_RESIDENT_EXISTS_EXCEPT_ID($resident_id, $id)) {
            $new_health_record_id = $health_record_model->MOD_UPDATE_HEALTH_RECORD($id, $data);

            // Log
            write_log(
                'EDIT_HEALTH_RECORD',
                'health_records',
                $new_health_record_id,
                "Updated health record for resident: $resident_id",
                session_get('user')['id']
            );

            flash('flash_notif', [
                'title' => 'Health Record Updated',
                'text' => 'The health record has been successfully updated.',
                'icon' => 'success',
            ]);
        } else {
            flash('flash_notif', [
                'title' => 'Health Record Exists',
                'text' => 'The health record already exists for this resident.',
                'icon' => 'error',
            ]);
        }

        return json([
            'success' => true,
            'message' => 'Health record updated successfully.'
        ]);
    }

    public function add_birth_record()
    {
        $child_resident_id = input('child_resident_id', null);
        $mother_resident_id = input('mother_resident_id', null);
        $date_of_birth = input('date_of_birth', null);
        $sex = input('sex', null);

        $birth_record_model = $this->model('Birth_Record_Model');

        $data = [
            'child_resident_id' => $child_resident_id,
            'mother_resident_id' => $mother_resident_id,
            'date_of_birth' => $date_of_birth,
            'sex' => $sex
        ];

        if (!$birth_record_model->MOD_CHECK_IF_CHILD_EXISTS($child_resident_id)) {
            $new_birth_record_id = $birth_record_model->MOD_INSERT_BIRTH_RECORD($data);

            // Log
            write_log(
                'ADD_BIRTH_RECORD',
                'birth_records',
                $new_birth_record_id,
                "Added new birth record for child: $child_resident_id",
                session_get('user')['id']
            );

            flash('flash_notif', [
                'title' => 'Birth Record Added',
                'text' => 'The birth record has been successfully added.',
                'icon' => 'success',
            ]);
        } else {
            flash('flash_notif', [
                'title' => 'Birth Record Exists',
                'text' => 'The birth record already exists for this child.',
                'icon' => 'error',
            ]);
        }

        return json([
            'success' => true,
            'message' => 'Birth record added successfully.'
        ]);
    }

    public function edit_birth_record()
    {
        $id = input('id', null);
        $child_resident_id = input('child_resident_id', null);
        $mother_resident_id = input('mother_resident_id', null);
        $date_of_birth = input('date_of_birth', null);
        $sex = input('sex', null);

        $birth_record_model = $this->model('Birth_Record_Model');

        $data = [
            'child_resident_id' => $child_resident_id,
            'mother_resident_id' => $mother_resident_id,
            'date_of_birth' => $date_of_birth,
            'sex' => $sex
        ];

        if (!$birth_record_model->MOD_CHECK_IF_CHILD_EXISTS_EXCEPT_ID($child_resident_id, $id)) {
            $new_birth_record_id = $birth_record_model->MOD_UPDATE_BIRTH_RECORD($id, $data);

            // Log
            write_log(
                'EDIT_BIRTH_RECORD',
                'birth_records',
                $new_birth_record_id,
                "Updated birth record for child: $child_resident_id",
                session_get('user')['id']
            );

            flash('flash_notif', [
                'title' => 'Birth Record Updated',
                'text' => 'The birth record has been successfully updated.',
                'icon' => 'success',
            ]);
        } else {
            flash('flash_notif', [
                'title' => 'Birth Record Exists',
                'text' => 'The birth record already exists for this child.',
                'icon' => 'error',
            ]);
        }

        return json([
            'success' => true,
            'message' => 'Birth record updated successfully.'
        ]);
    }

    public function get_child_resident_date_of_birth_and_sex()
    {
        $child_resident_id = input('child_resident_id', null);

        $resident_model = $this->model('Resident_Model');

        $date_of_birth = $resident_model->MOD_GET_RESIDENT_DATE_OF_BIRTH_AND_SEX($child_resident_id);

        return json([
            'success' => true,
            'message' => 'Date of birth and sex retrieved successfully.',
            'date_of_birth' => $date_of_birth['date_of_birth'],
            'sex' => $date_of_birth['sex']
        ]);
    }

    public function add_migration_record()
    {
        $resident_id = input('resident_id', null);
        $migration_type = input('migration_type', null);
        $date_of_migration = input('date_of_migration', null);
        $origin = input('origin', null);
        $destination = input('destination', null);

        $migration_record_model = $this->model('Migration_Record_Model');
        $resident_model = $this->model('Resident_Model');

        $data = [
            'resident_id' => $resident_id,
            'migration_type' => $migration_type,
            'date_of_migration' => $date_of_migration,
            'origin' => $origin,
            'destination' => $destination
        ];

        if (!$migration_record_model->MOD_CHECK_IF_MIGRATION_RECORD_EXISTS($resident_id, $migration_type, $date_of_migration)) {
            $new_migration_record_id = $migration_record_model->MOD_INSERT_MIGRATION_RECORD($data);

            if ($migration_type === 'OUT') {
                // Update resident status to "Inactive"
                $resident_model->MOD_UPDATE_RESIDENT_STATUS($resident_id, 'Transferred');
            } elseif ($migration_type === 'IN') {
                // Update resident status to "Active"
                $resident_model->MOD_UPDATE_RESIDENT_STATUS($resident_id, 'Active');
            }

            // Log
            write_log(
                'ADD_MIGRATION_RECORD',
                'migration_records',
                $new_migration_record_id,
                "Added new migration record for resident: $resident_id",
                session_get('user')['id']
            );

            flash('flash_notif', [
                'title' => 'Migration Record Added',
                'text' => 'The migration record has been successfully added.',
                'icon' => 'success',
            ]);
        } else {
            flash('flash_notif', [
                'title' => 'Migration Record Exists',
                'text' => 'The migration record already exists for this resident.',
                'icon' => 'error',
            ]);
        }

        return json([
            'success' => true,
            'message' => 'Migration record added successfully.'
        ]);
    }

    public function edit_migration_record()
    {
        $id = input('id', null);
        $resident_id = input('resident_id', null);
        $migration_type = input('migration_type', null);
        $date_of_migration = input('date_of_migration', null);
        $origin = input('origin', null);
        $destination = input('destination', null);

        $migration_record_model = $this->model('Migration_Record_Model');
        $resident_model = $this->model('Resident_Model');

        $data = [
            'resident_id' => $resident_id,
            'migration_type' => $migration_type,
            'date_of_migration' => $date_of_migration,
            'origin' => $origin,
            'destination' => $destination
        ];

        if (!$migration_record_model->MOD_CHECK_IF_MIGRATION_RECORD_EXISTS_EXCEPT_CURRENT($id, $resident_id, $migration_type, $date_of_migration)) {
            $new_migration_record_id = $migration_record_model->MOD_UPDATE_MIGRATION_RECORD($id, $data);

            if ($migration_type === 'OUT') {
                // Update resident status to "Inactive"
                $resident_model->MOD_UPDATE_RESIDENT_STATUS($resident_id, 'Transferred');
            } elseif ($migration_type === 'IN') {
                // Update resident status to "Active"
                $resident_model->MOD_UPDATE_RESIDENT_STATUS($resident_id, 'Active');
            }

            // Log
            write_log(
                'EDIT_MIGRATION_RECORD',
                'migration_records',
                $new_migration_record_id,
                "Updated migration record for resident: $resident_id",
                session_get('user')['id']
            );

            flash('flash_notif', [
                'title' => 'Migration Record Updated',
                'text' => 'The migration record has been successfully updated.',
                'icon' => 'success',
            ]);
        } else {
            flash('flash_notif', [
                'title' => 'Migration Record Exists',
                'text' => 'The migration record already exists for this resident.',
                'icon' => 'error',
            ]);
        }

        return json([
            'success' => true,
            'message' => 'Migration record updated successfully.'
        ]);
    }

    public function add_death_record()
    {
        $resident_id = input('resident_id', null);
        $date_of_death = input('date_of_death', null);
        $cause_of_death = input('cause_of_death', null);
        $manner_of_death = input('manner_of_death', null);

        $death_record_model = $this->model('Death_Record_Model');
        $resident_model = $this->model('Resident_Model');

        $data = [
            'resident_id' => $resident_id,
            'date_of_death' => $date_of_death,
            'cause_of_death' => $cause_of_death,
            'manner_of_death' => $manner_of_death
        ];

        if (!$death_record_model->MOD_CHECK_IF_DEATH_RECORD_EXISTS($resident_id)) {
            $new_death_record_id = $death_record_model->MOD_INSERT_DEATH_RECORD($data);

            // Update resident status to "Deceased"
            $resident_model->MOD_UPDATE_RESIDENT_STATUS($resident_id, 'Deceased');

            // Log
            write_log(
                'ADD_DEATH_RECORD',
                'death_records',
                $new_death_record_id,
                "Added new death record for resident: $resident_id",
                session_get('user')['id']
            );

            flash('flash_notif', [
                'title' => 'Death Record Added',
                'text' => 'The death record has been successfully added.',
                'icon' => 'success',
            ]);
        } else {
            flash('flash_notif', [
                'title' => 'Death Record Exists',
                'text' => 'The death record already exists for this resident.',
                'icon' => 'error',
            ]);
        }

        return json([
            'success' => true,
            'message' => 'Death record added successfully.'
        ]);
    }

    public function edit_death_record()
    {
        $id = input('id', null);
        $resident_id = input('resident_id', null);
        $date_of_death = input('date_of_death', null);
        $cause_of_death = input('cause_of_death', null);
        $manner_of_death = input('manner_of_death', null);

        $death_record_model = $this->model('Death_Record_Model');
        $resident_model = $this->model('Resident_Model');

        $data = [
            'resident_id' => $resident_id,
            'date_of_death' => $date_of_death,
            'cause_of_death' => $cause_of_death,
            'manner_of_death' => $manner_of_death
        ];

        if (!$death_record_model->MOD_CHECK_IF_DEATH_RECORD_EXISTS_EXCEPT_CURRENT($id, $resident_id)) {
            $death_record_model->MOD_UPDATE_DEATH_RECORD($id, $data);

            // Update resident status to "Deceased"
            $resident_model->MOD_UPDATE_RESIDENT_STATUS($resident_id, 'Deceased');

            // Log
            write_log(
                'EDIT_DEATH_RECORD',
                'death_records',
                $id,
                "Edited death record for resident: $resident_id",
                session_get('user')['id']
            );

            flash('flash_notif', [
                'title' => 'Death Record Updated',
                'text' => 'The death record has been successfully updated.',
                'icon' => 'success',
            ]);
        } else {
            flash('flash_notif', [
                'title' => 'Death Record Exists',
                'text' => 'The death record already exists for this resident.',
                'icon' => 'error',
            ]);
        }

        return json([
            'success' => true,
            'message' => 'Death record added successfully.'
        ]);
    }
}
