<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where("email", $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            $token = $user->createToken('access-token')->plainTextToken;

            $response = [
                "status" => 1,
                "token" => $token,
                "msg" => "Login Successfully"
            ];
        } else {
            $response = [
                "status" => 0,
                "msg" => "invalid login details"
            ];
        }

        return response()->json($response);
    }
}
