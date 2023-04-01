<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{

    public function login(Request $request): JsonResponse
    {
        $rules = [
            'name' => ['required', 'string', 'exists:users'],
            'password' => ['required', 'string', 'min:5'],
        ];
        $data = $request->validate($rules);
        if (Auth::attempt($data)) {
            /** @var User $user */
            $user = Auth::user();
            $token = $user->createToken($user->name)->plainTextToken;
            $response = [
                'user' => $user,
                'access_token' => $token,
                'role' => $user->roles()->first(),
                'permissions' => $user->permissions
            ];
            $message = "Success";
            $result = true;
        } else {
            $response = null;
            $message = "Incorrect name or password";
            $result = false;
        }
        return self::getJsonResponse($message, $response, $result);

    }

    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = \auth()->user();
        $user->tokens()->delete();
        Auth::logout();
        return self::getJsonResponse('Success');
    }

    public function roles(): JsonResponse
    {
        $roles = Role::query()->get(['id', 'name']);
        return self::getJsonResponse('Success', $roles);
    }

    public function permissions(): JsonResponse
    {
        $permissions = Permission::query()->get(['id', 'name']);
        return self::getJsonResponse('SUccess', $permissions);
    }
}
