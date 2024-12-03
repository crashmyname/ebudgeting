<?php

namespace App\Controllers;
use App\Models\Fiscal;
use App\Models\User;
use Support\BaseController;
use Support\DataTables;
use Support\Request;
use Support\Session;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class FiscalController extends BaseController
{
    public function getFiscal(Request $request)
    {
        if(Request::isAjax()){
            $fiscal = Fiscal::all();
            return DataTables::of($fiscal)->make(true);
        }
    }
    public function index()
    {
        $title = 'Fiscal';
        $user = User::query()->leftJoin('menu_access','menu_access.uid','=','users.uid')
        ->where('menu_access.uid','=',Session::user()->uid)
        ->where('menu_access.menu_id','=',8)
        ->where('menu_access.can_view','=',1)
        ->first();
        
        if (!$user) {
            View::error('errors/403');
            return;
        }

        if(!$user && !$user->menu_id == 8 && !$user->can_view == 1){
            View::error('errors/403');
            return;
        }
        return view('fiscal/fiscal',['title'=>$title],'layout/app');
    }

    public function show($id)
    {
        // Tampilkan resource dengan ID: $id
    }

    public function store(Request $request)
    {
        // Simpan resource baru
    }

    public function update(Request $request, $id)
    {
        // Update resource dengan ID: $id
    }

    public function destroy($id)
    {
        // Hapus resource dengan ID: $id
    }
}
