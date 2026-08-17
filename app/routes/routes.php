<?php
// app/routes/routes.php

return function (Router $router) {
    // Home routes
    $router->get('/', 'HomeController@index');

    // Auth routes
    $router->get('/login', 'AuthController@index');
    $router->get('/forgot-password', 'AuthController@forgot_password');
    $router->post('/authenticate', 'AuthController@authenticate');
    $router->post('/validate-username', 'AuthController@validate_username');
    $router->post('/get-security-questions', 'AuthController@get_security_questions');
    $router->post('/verify-security-answers', 'AuthController@verify_security_answers');
    $router->post('/reset-password', 'AuthController@reset_password');
    $router->post('/logout', 'AuthController@logout');

    // Admin routes
    $router->get('/dashboard', 'AdminController@dashboard');
    $router->get('/households', 'AdminController@households');
    $router->get('/residents', 'AdminController@residents');
    $router->get('/socio-economic', 'AdminController@socio_economic');
    $router->get('/programs', 'AdminController@programs');
    $router->get('/programs-beneficiaries', 'AdminController@programs_beneficiaries');
    $router->get('/health-records', 'AdminController@health_records');
    $router->get('/birth-records', 'AdminController@birth_records');
    $router->get('/migration-records', 'AdminController@migration_records');
    $router->get('/death-records', 'AdminController@death_records');
    $router->get('/user-management', 'AdminController@user_management');
    $router->get('/system-logs', 'AdminController@system_logs');
    $router->get('/export-logs', 'AdminController@export_logs');
    $router->post('/add-user-account', 'AdminController@add_user_account');
    $router->post('/update-security-questions', 'AdminController@update_security_questions');
    $router->post('/update-user-account', 'AdminController@update_user_account');
    $router->post('/update-user-account-super-admin-mode', 'AdminController@update_user_account_super_admin_mode');
    $router->post('/disable-user-account', 'AdminController@disable_user_account');
    $router->post('/enable-user-account', 'AdminController@enable_user_account');
    $router->post('/update-account', 'AdminController@update_account');
    $router->post('/search-user', 'AdminController@search_user');
    $router->post('/clear-logs', 'AdminController@clear_logs');
    $router->post('/generate-household-code', 'AdminController@generate_household_code');
    $router->post('/add-household', 'AdminController@add_household');
    $router->post('/update-household', 'AdminController@update_household');
    $router->post('/add-resident', 'AdminController@add_resident');
    $router->post('/edit-resident', 'AdminController@edit_resident');
    $router->post('/add-socio-economic-profile', 'AdminController@add_socio_economic_profile');
    $router->post('/edit-socio-economic-profile', 'AdminController@edit_socio_economic_profile');
    $router->post('/add-program', 'AdminController@add_program');
    $router->post('/edit-program', 'AdminController@edit_program');
    $router->post('/add-program-beneficiary', 'AdminController@add_program_beneficiary');
    $router->post('/update-beneficiary', 'AdminController@update_beneficiary');
    $router->post('/add-health-record', 'AdminController@add_health_record');
    $router->post('/edit-health-record', 'AdminController@edit_health_record');
    $router->post('/add-birth-record', 'AdminController@add_birth_record');
    $router->post('/edit-birth-record', 'AdminController@edit_birth_record');
    $router->post('/get-child-resident-date-of-birth-and-sex', 'AdminController@get_child_resident_date_of_birth_and_sex');
    $router->post('/add-migration-record', 'AdminController@add_migration_record');
    $router->post('/edit-migration-record', 'AdminController@edit_migration_record');
    $router->post('/add-death-record', 'AdminController@add_death_record');
    $router->post('/edit-death-record', 'AdminController@edit_death_record');

    // System Update Routes
    $router->get('/check-updates', 'UpdateController@check');
    $router->post('/update-system', 'UpdateController@run');

    // System Information Routes
    $router->post('/update-system-info', 'SystemInformationController@update_system_info');

    // Sample Data Seeder Route
    $router->post('/seed-sample-data', 'SeedSampleDataController@seed_sample_data');
};
