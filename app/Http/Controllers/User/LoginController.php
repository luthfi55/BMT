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
            'pin' => 'required|numeric',
        ]);

        $pin = $request->input('pin');
        $user = User::where('pin', $pin)->first();

        if ($user) {
            Auth::login($user);

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
            ]);
        }

        return response()->json([
            'message' => 'Invalid PIN',
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
