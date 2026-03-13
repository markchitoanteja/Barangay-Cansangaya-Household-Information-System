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
    $router->get('/reports', 'AdminController@reports');
    $router->get('/user-management', 'AdminController@user_management');
    $router->post('/add-user-account', 'AdminController@add_user_account');
    $router->post('/update-user-account', 'AdminController@update_user_account');
    $router->post('/disable-user-account', 'AdminController@disable_user_account');
    $router->post('/enable-user-account', 'AdminController@enable_user_account');
    $router->post('/update-account', 'AdminController@update_account');
    $router->post('/search-user', 'AdminController@search_user');
    $router->post('/clear-logs', 'AdminController@clear_logs');
    $router->get('/export-logs', 'AdminController@export_logs');
};
