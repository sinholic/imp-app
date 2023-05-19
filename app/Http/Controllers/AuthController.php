<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'username' => 'required|min:2',
            'password' => 'required|min:5',
        ],[
            'username.required' => 'Username is required',
            'username.min' => 'Username must be at least 2 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 5 characters'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return $this->createNewToken($token, 200);
    }

    /**
     * Signup a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:2',
            'password' => 'required|min:5',
            'fullname' => 'required',
        ], [
            'username.required' => 'Username is required',
            'username.min' => 'Username must be at least 2 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 5 characters',
            'fullname.required' => 'Fullname is required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Cek apakah pengguna sudah ada dalam database
        $user = User::where('username', $request->username)->first();
        if ($user) {
            return response()->json(['error' => 'User already exists'], 409);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        $token = auth()->attempt($validator->validated());

        return $this->createNewToken($token, 201);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token, $code){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ], $code);
    }

}
