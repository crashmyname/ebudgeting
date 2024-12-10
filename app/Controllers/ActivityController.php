<?php

namespace App\Controllers;

use Support\BaseController;
use Support\Request;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class ActivityController extends BaseController
{
    // Controller logic here
    public function activity()
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Unknown IP';
        $hostname = gethostbyaddr($ip);
        return view('test',['ip'=>$ip,'hostname'=>$hostname]);
    }
}
