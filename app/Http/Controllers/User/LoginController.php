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
            $tokenLogin = $user->createToken('authToken')->accessToken;            


            return response()->json([
                'status' => 'successfully',
                'access_token' => $tokenLogin->token,
                'user' => $user                
            ]);
        }

        return response()->json([
            'status' => 'Invalid PIN',
        ], 401);
    }

    /**
     * Logout the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $user = Auth::user();
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
