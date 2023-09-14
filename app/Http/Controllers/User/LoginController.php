<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /**
     * Login the user based on the provided PIN.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'pin' => 'required',
        ]);
    
        $pin = $request->input('pin');
        $user = User::where('pin', $pin)->first();
    
        if ($user) {
            $accessToken = $user->createToken('API Token')->accessToken;
    
            $accessTokenModel = $user->tokens()->where('name', 'API Token')->latest()->first();
    
            if ($accessTokenModel) {
                // $scopes = $accessTokenModel->scopes ?? [];
                $scopes = $user;
                $accessTokenModel->forceFill([
                    'scopes' => $scopes,
                ])->save();
            }
    
            return response()->json([
                'message' => 'Login Successfully',
                'data' => [                    
                    'access_token' => $accessToken
                ],                                
            ], 200);
        }
    
        return response()->json([
            'message' => 'Invalid Pin',            
            'access_token' => Null,            
        ], 401);
    }
    
    /**
     * Logout the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
{
    $user = $request->user(); 

    // Revoke the user's access token
    if ($user) {
        $user->tokens()->delete(); 
    }

    return response()->json([
        'message' => 'Logged out successfully',
        'data' => ['id' => $user->id]
    ], 200);
}
}
