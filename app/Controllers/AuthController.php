<?php

namespace App\Controllers;
use Support\BaseController;
use Support\Request;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class AuthController extends BaseController
{
    // Controller logic here
    public function index()
    {
        return view('auth/login');
    }
}
