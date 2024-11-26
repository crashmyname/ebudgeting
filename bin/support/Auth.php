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
            Session::set('user', $user->toArray());
            // SessionMiddleware::regenerate();
            return true;
        }
        return false;
    }
}
?>