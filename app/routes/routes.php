<?php
// app/routes/routes.php

return function (Router $router) {
    // Home routes
    $router->get('/', 'HomeController@index');

    // Auth routes
    $router->get('/login', 'AuthController@index');
    $router->get('/forgot-password', 'AuthController@forgot_password');
    $router->post('/authenticate', 'AuthController@authenticate');
    $router->post('/logout', 'AuthController@logout');

    // Admin routes
    $router->get('/dashboard', 'AdminController@dashboard');
};
