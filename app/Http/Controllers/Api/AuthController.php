<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;
use Validator;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|string|confirmed',
            'positionID' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401]);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->positionID = $request->positionID;
        $def = $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401]);
        }
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),'code' => 205
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $userEdit = User::find((int)$id);

        // $user = User::find((integer)$id);
        // $user->name=$request->name;
        // $user->email=$request->email;
        // $user->phone =$request->phone;
        // $user->password =bcrypt($request->password);
        // $user->positionID =$request->positionID;
        if ($userEdit == true) {
            $userEdit->fill($request->all());
            $validator = Validator::make(json_decode($userEdit, TRUE), [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            if (Gate::allows('admin-user', $user->id)) {
                $userEdit->save();
                return response()->json(['success' => true, 'code' => '200']);
            } else {
                return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to update"]);
            }
        } else {
            return response()->json(['success' => false, 'code' => '404']);
        }


        // $user->save();
        // return response()->json(['success' => true, 'code' => 200]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function index(Request $request)
    {
        return response()->json($request->user());
    }
}