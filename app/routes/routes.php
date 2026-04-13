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
    $router->get('/demographics', 'AdminController@demographics');
    $router->get('/housing-and-facilities', 'AdminController@housing_and_facilities');
    $router->get('/livelihood', 'AdminController@livelihood');
    $router->get('/social-sectors', 'AdminController@social_sectors');
    $router->get('/health-monitoring', 'AdminController@health_monitoring');
    $router->get('/user-management', 'AdminController@user_management');
    $router->post('/add-user-account', 'AdminController@add_user_account');
    $router->post('/update-security-questions', 'AdminController@update_security_questions');
    $router->post('/update-user-account', 'AdminController@update_user_account');
    $router->post('/update-user-account-super-admin-mode', 'AdminController@update_user_account_super_admin_mode');
    $router->post('/disable-user-account', 'AdminController@disable_user_account');
    $router->post('/enable-user-account', 'AdminController@enable_user_account');
    $router->post('/update-account', 'AdminController@update_account'); 
    $router->post('/search-user', 'AdminController@search_user');
    $router->get('/export-logs', 'AdminController@export_logs');
    $router->post('/clear-logs', 'AdminController@clear_logs');
    $router->post('/generate-household-code', 'AdminController@generate_household_code');
    $router->post('/add-household', 'AdminController@add_household');
    $router->post('/update-household', 'AdminController@update_household');
    $router->post('/add-resident', 'AdminController@add_resident');
    $router->post('/edit-resident', 'AdminController@edit_resident');

    // System Update Routes
    $router->get('/check-updates', 'UpdateController@check');
    $router->post('/update-system', 'UpdateController@run');

    // System Information Routes
    $router->post('/update-system-info', 'SystemInformationController@update_system_info');
};
