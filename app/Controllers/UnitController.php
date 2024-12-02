<?php

namespace App\Controllers;
use App\Models\Unit;
use Support\BaseController;
use Support\DataTables;
use Support\Request;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class UnitController extends BaseController
{
    // Controller logic here
    public function getUnit(Request $request)
    {
        if(Request::isAjax()){
            $unit = Unit::all();
            return DataTables::of($unit)->make(true);
        }
    }

    public function index()
    {
        $title = 'Unit';
        return view('unit/unit',['title'=>$title],'layout/app');
    }
}
