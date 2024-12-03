<?php

namespace App\Controllers;
use App\Models\MenuManagement;
use App\Models\User;
use Support\BaseController;
use Support\DataTables;
use Support\Date;
use Support\Request;
use Support\Response;
use Support\Session;
use Support\UUID;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class UserController extends BaseController
{
    // Controller logic here
    public function getUser(Request $request)
    {
        if (Request::isAjax()) {
            $user = User::query()->select('uuid', 'name', 'username', 'password', 'dept', 'email', 'level', 'role_id')->where('deleted_at', '=', null)->get();
            return DataTables::of($user)->make(true);
        }
    }
    public function index()
    {
        $title = 'Users';
        return view('users/user', ['title' => $title], 'layout/app');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|min:4',
            'name' => 'required|min:3',
            'dept' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
        if($validator){
            return Response::json(['status'=>$validator]);
        }
        $user = User::create([
            'uuid' => UUID::generateUuid(),
            'username' => $request->username,
            'name' => $request->name,
            'dept' => $request->departement,
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'level' => $request->level,
            'role_id' => $request->role_id,
            'created_by' => $request->name,
            'updated_by' => $request->name,
        ]);
        return Response::json(['status' => 200]);
    }

    public function role(Request $request, $id)
    {
        // Ambil user berdasarkan UUID
        $user = User::query()->where('uuid', '=', $id)->first();

        if ($user) {
            // Daftar menu dan ID-nya
            $menus = [
                'menu_user' => 1,
                'menu_category' => 2,
                'menu_timer' => 3,
                'menu_item' => 4,
                'menu_type' => 5,
                'menu_unit' => 6,
                'menu_dept' => 7,
                'menu_fiscal' => 8,
                'menu_plan' => 9,
                'menu_forecase' => 10,
                'menu_actual' => 11,
            ];

            $requestData = $request->all();
            foreach ($menus as $menuKey => $menuId) {
                if (isset($requestData[$menuKey])) {
                    $permission = $this->convertToPermissions($requestData[$menuKey]);
                    $existingRecord = MenuManagement::query()->where('menu_id','=' ,$menuId)
                                                ->where('uid', '=',$user->uid)
                                                ->first();
                    if($existingRecord){
                        // $existingRecord->update([
                        //     'can_view' => $permission['can_view'],
                        //     'can_create' => $permission['can_create'],
                        //     'can_update' => $permission['can_update'],
                        //     'can_delete' => $permission['can_delete'],
                        // ]);
                        $existingRecord->menu_id = $menuId;
                        $existingRecord->can_view = $existingRecord->can_view == 1 ? 1 : $permission['can_view'];
                        $existingRecord->can_create = $existingRecord->can_create == 1 ? 1 : $permission['can_create'];
                        $existingRecord->can_update = $existingRecord->can_update == 1 ? 1 : $permission['can_update'];
                        $existingRecord->can_delete = $existingRecord->can_delete == 1 ? 1 : $permission['can_delete'];
                        $existingRecord->save();
                    } else {
                        // Simpan ke database
                        MenuManagement::create([
                            'menu_id' => $menuId,
                            'role_id' => 1,
                            'uid' => $user->uid,
                            'can_view' => $permission['can_view'],
                            'can_create' => $permission['can_create'],
                            'can_update' => $permission['can_update'],
                            'can_delete' => $permission['can_delete'],
                        ]);
                    }
                }
            }

            return Response::json(['status' => 200, 'message' => 'Permissions updated successfully']);
        } else {
            return Response::json(['message' => 'User not found'], 404);
        }
    }

    /**
     * Konversi array dari request menjadi permissions.
     */
    private function convertToPermissions(array $menuData): array
    {
        // Default nilai permissions
        $permissions = [
            'can_view' => 0,
            'can_create' => 0,
            'can_update' => 0,
            'can_delete' => 0,
        ];

        // Sesuaikan dengan nilai yang dipilih
        foreach ($menuData as $value) {
            if ($value === 'view') {
                $permissions['can_view'] = 1;
            } elseif ($value === 'add') {
                $permissions['can_create'] = 1;
            } elseif ($value === 'edit') {
                $permissions['can_update'] = 1;
            } elseif ($value === 'delete') {
                $permissions['can_delete'] = 1;
            }
        }

        return $permissions;
    }

    public function update(Request $request, $id)
    {
        $user = User::query()->where('uuid', '=', $id)->first();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->dept = $request->departement;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->level = $request->level;
        $user->role_id = $request->role_id;
        $user->save();
        return Response::json(['status' => 200]);
    }

    public function delete(Request $request, $id)
    {
        $user = User::query()->where('uuid', '=', $id)->first();
        $user->deleted_by = Session::user()->username;
        $user->deleted_at = Date::Now();
        $user->save();
        return Response::json(['status' => 200]);
    }

    public function profile(Request $request, $id)
    {
        $user = User::query()->where('uuid','=',$id)->first();
        return view('users/profil',['user'=>$user],'layout/app');
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::query()->where('uuid','=',$id)->first();
        if($user->username == Session::user()->username){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->dept = $request->dept;
            if($request->password){
                $user->password = password_hash($request->password,PASSWORD_BCRYPT);
            }
            if($request->getClientOriginalName('foto')){
                $path = storage_path('profile-users');
                if(!file_exists($path)){
                    mkdir($path,0777,true);
                }
                $oldFile = $path.'/'.$user->profile;
                if(file_exists($oldFile)){
                    unlink($oldFile);
                }
                $user->profile = $request->getClientOriginalName('foto');
                $tempPath = $request->getPath('foto');
                $destination = $path.'/'.$user->profile;
                move_uploaded_file($tempPath,$destination);
            }
            $user->save();
            Session::flash('success', 'Profile berhasil diperbarui!');
            return redirect('/home');
        }
        Response::json(['status'=>403,'message'=>'Forbiden Access for update profile isnt you']);
    }
}
