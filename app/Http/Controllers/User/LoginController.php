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
            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json([
                'status' => 'successfully',
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
        Auth::logout();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
