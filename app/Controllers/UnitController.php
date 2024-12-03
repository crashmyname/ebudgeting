<?php

namespace App\Controllers;
use App\Models\Unit;
use App\Models\User;
use Support\BaseController;
use Support\DataTables;
use Support\Request;
use Support\Session;
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
        $user = User::query()->leftJoin('menu_access','menu_access.uid','=','users.uid')
        ->where('menu_access.uid','=',Session::user()->uid)
        ->where('menu_access.menu_id','=',6)
        ->where('menu_access.can_view','=',1)
        ->first();
        
        if (!$user) {
            View::error('errors/403');
            return;
        }

        if(!$user && !$user->menu_id == 6 && !$user->can_view == 1){
            View::error('errors/403');
            return;
        }
        return view('unit/unit',['title'=>$title],'layout/app');
    }
}
