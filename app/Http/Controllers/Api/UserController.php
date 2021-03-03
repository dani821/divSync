<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteUser($id): JsonResponse
    {
        if(Auth::id() == $id)
        {
            return response()->json([
               'status' => 0,
               'msg' => 'Cannot delete current logged user'
            ]);
        }

        $user = User::find($id);

        if( empty($user) )
        {
            return response()->json([
                'status' => 0,
                'msg' => 'User not found.'
            ]);
        }

        $user->delete();

        return response()->json([
            'status' => 1,
            'msg' => 'User Deleted Successfully.'
        ]);

    }
}
