<?php
namespace Support;
use App\Models\User;
use Support\Session;
use Support\SessionMiddleware;

class Auth{
    public static function attempt($credentials)
    {
        $user = User::query()
                ->where('username','=',$credentials['identifier'])
                ->first();
        if(!$user){
            User::query()
                ->where('email','=',$credentials['identifier'])
                ->first();
        }
        if($user && password_verify($credentials['password'],$user->password)){
            $params = [':user_id' => $user->uid];
            $menu = DB::raw('SELECT menu.menu_id,menu.name,menu.url,menu_access.uid,menu_access.can_view,menu_access.can_create,menu_access.can_update,menu_access.can_delete,menu_access.role_id FROM menu LEFT JOIN menu_access ON menu.menu_id = menu_access.menu_id WHERE menu_access.uid = :user_id',$params);
            $userData = $user->toArray();
            $userData['menus'] = $menu;
            Session::set('user', $userData);
            SessionMiddleware::regenerate();
            return true;
        }
        return false;
    }
}
?>