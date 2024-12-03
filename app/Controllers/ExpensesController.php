<?php

namespace App\Controllers;
use App\Models\User;
use Support\BaseController;
use Support\Request;
use Support\Session;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class ExpensesController extends BaseController
{
    // Controller logic here
    public function indexPlan()
    {
        $title = 'Plan Expenses';
        $user = User::query()->leftJoin('menu_access','menu_access.uid','=','users.uid')
        ->where('menu_access.uid','=',Session::user()->uid)
        ->where('menu_access.menu_id','=',9)
        ->where('menu_access.can_view','=',1)
        ->first();
        if(!$user){
            View::error('errors/403');
        }
        return view('expenses/plan',['title'=>$title],'layout/app');
    }
    public function indexForecast()
    {
        $title = 'Forecast Expenses';
        $user = User::query()->leftJoin('menu_access','menu_access.uid','=','users.uid')
        ->where('menu_access.uid','=',Session::user()->uid)
        ->where('menu_access.menu_id','=',10)
        ->where('menu_access.can_view','=',1)
        ->first();
        if(!$user){
            View::error('errors/403');
        }
        return view('expenses/forecast',['title'=>$title],'layout/app');
    }
    public function indexActual()
    {
        $title = 'Actual Expenses';
        $user = User::query()->leftJoin('menu_access','menu_access.uid','=','users.uid')
        ->where('menu_access.uid','=',Session::user()->uid)
        ->where('menu_access.menu_id','=',11)
        ->where('menu_access.can_view','=',1)
        ->first();
        if(!$user){
            View::error('errors/403');
        }
        return view('expenses/actual',['title'=>$title],'layout/app');
    }
}
