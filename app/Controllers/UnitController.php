<?php

namespace App\Controllers;
use App\Models\Unit;
use App\Models\User;
use Support\BaseController;
use Support\DataTables;
use Support\Request;
use Support\Response;
use Support\Session;
use Support\UUID;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class UnitController extends BaseController
{
    // Controller logic here
    public function getUnit(Request $request)
    {
        if(Request::isAjax()){
            $unit = Unit::query()->where('deleted_at','=',null)->get();
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

    public function create(Request $request)
    {
        $unit = Unit::query()->orderBy('code_unit','desc')->first();
        if($unit){
            $lastCode = intval(substr($unit->code_unit, 3)); // Mengambil angka dari kode terakhir
            $newCode = 'T' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);
            $unit = Unit::create([
                'uuid' => UUID::generateUuid(),
                'code_unit' => $newCode,
                'unit' => $request->unit
            ]);
            return Response::json(['status'=>200]);
        } else {
            $unit = Unit::create([
                'uuid' => UUID::generateUuid(),
                'code_unit' => 'T0001',
                'unit' => $request->unit
            ]);
            return Response::json(['status'=>200]);
        }
    }
}
