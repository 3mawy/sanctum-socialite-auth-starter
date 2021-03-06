<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registers the user in the database.
     *
     * @param $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);
        /*      $user = User::create([
                      'name' => $validatedData['name'],
                           'email' => $validatedData['email'],
                           'password' => Hash::make($validatedData['password']),
               ]);
        */
        $accessToken = $user->createToken('auth_token')->plainTextToken;

        return response(['user' => $user, 'access_token' => $accessToken], 201);
    }

    /**
     * Login the user.
     *
     * @param $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'This User does not exist, check your details'], 400);
        }

        $accessToken = auth()->user()->createToken('auth_token')->plainTextToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function me(Request $request)
    {
        return response(['user'], 221);
    }
}
