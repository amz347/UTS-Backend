<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        /**
         * Fitur Register
         * Ambil input name, email dan password
         * Input datanya ke database menggunakan User Model
         */

        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        User::create($input);

        $data = [
            'message' => 'Register is successfully'
        ];

        return response()->json($data, 200);
    }

    public function login(Request $request)
    {
       /**
        * Login Feature
        * Retrieve input data (name, email, and password) from the user
        * Retrieve data (name, email, and password) from the database based on the email
        * Compare user input data with data from the database
        */

        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($input)) {
            $user = User::where('email', $input['email'])->first();

            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login is successfully',
                'token' => $token->plainTextToken
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Login is invalid'
            ];

            return response()->json($data, 401);
        }
    }
}