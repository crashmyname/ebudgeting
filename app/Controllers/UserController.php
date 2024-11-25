<?php

namespace App\Controllers;
use App\Models\User;
use Support\BaseController;
use Support\DataTables;
use Support\Request;
use Support\Response;
use Support\UUID;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class UserController extends BaseController
{
    // Controller logic here
    public function getUser(Request $request)
    {
        if(Request::isAjax()){
            $user = User::query()
                    ->select('uuid','name','username','password','dept','email','level','role_id')
                    ->get();
            return DataTables::of($user)
                    ->make(true);
        }
    }
    public function index()
    {
        $title = 'Users';
        return view('users/user',['title'=>$title],'layout/app');
    }

    public function create(Request $request)
    {
        // $validator = Validator::make()
        $user = User::create([
            'uuid' => UUID::generateUuid(),
            'username' => $request->username,
            'name' => $request->name,
            'dept' => $request->departement,
            'email' => $request->email,
            'password' => password_hash($request->password,PASSWORD_BCRYPT),
            'level' => $request->level,
            'role_id' => $request->role_id,
            'created_by' => $request->name,
            'updated_by' => $request->name,
        ]);
        return Response::json(['status'=>200]);
    }
}
