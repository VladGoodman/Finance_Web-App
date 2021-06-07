<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ], 400);
        }
        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'status'=>true,
            'success'=>'Registration completed successfully',
            'token'=>$token
        ], 200);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
            [
                'status'=>false
            ], 400);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'token' => $token
        ];
        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
         return response([
            'success'=>true
         ], 200);
    }

    public function test(Request $request){
        return $request->user();
    }
}
