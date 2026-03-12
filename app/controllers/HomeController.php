<?php

require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';

class HomeController extends Controller
{   
    public function index()
    {
        if (session_get('is_login', false) === true) {
            redirect('dashboard');
            return;
        }

        redirect('login');
    }
}
