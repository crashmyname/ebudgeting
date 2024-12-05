<?php

namespace App\Controllers\Api;
use App\Models\Category;
use Firebase\JWT\JWT;
use Support\Auth;
use Support\BaseController;
use Support\Request;
use Support\Response;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class TestController extends BaseController
{
    // Controller logic here
    public function loginApi(Request $request)
    {
        $credentials = [
            'identifier' => $request->username,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            // $token = createToken();
            $payload = [
                'iss' => 'http://localhost/ebudgeting', // Issuer
                'aud' => 'http://localhost/ebudgeting', // Audience
                'iat' => time(), // Issued At
                'exp' => time() + 60 * 60, // Expiry (1 jam)
            ];

            // Generate token
            $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
            return Response::json(['status' => 200, 'message' => 'success login', 'token' => $token]);
        }
    }
    public function testApi()
    {
        $category = Category::all();
        return Response::json(['status'=>200,'message'=>'berhasil','data'=>$category]);
    }
}
