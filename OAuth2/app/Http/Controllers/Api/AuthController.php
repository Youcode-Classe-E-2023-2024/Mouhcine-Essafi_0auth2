<?php

//namespace app\Http\Controllers\Api;
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
//        $request->validate([
//            'email' => 'required|string',
//            'password' => 'required|string'
//        ]);
        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)){
            return response()->json([
                "message" => "Invalid email or password"
            ], 401);
        }
        $user = $request->user();
        $token = $user->createToken('Access Token');
        $user->access_token = $token->accessToken;

        return response()->json([
            "user" => $user
        ], 200);
    }

    public function register(Request $request)
    {
//        $request->validate([
//           'name' => 'required|string',
//            'email' => 'required|string|unique:users,email,',
//            'password' => 'required|string|min:8',
//            'role' => 'required|exists:roles,id',
//        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);
        $user->save();
        return response()->json([
            "message" => "User registered successfully"
        ], 201);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json([
            "message" => "User logged out successfully"
        ], 200);
    }
    public function index()
    {
        echo "Hello World";
    }
}
