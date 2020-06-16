<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        try {
            if (Auth::attempt($request->only('phone', 'password'))) {
                return $this->createAccessToken(auth()->user());
            }

            return respondError(UNAUTHORIZED, 401);
        } catch (\Exception $e) {
            return respondError($e->getMessage());
        }
    }

    /**
     * Create auth user access token
     * @param  Object $user
     * @return Token
     */
    protected function createAccessToken($user)
    {
        if ($token = $user->createToken('Plasma Bank Password Grant Client')->accessToken) {
            return (new UserResource($user))->additional([
                'token' => $token,
            ]);
        }

        throw new \Exception('Failed to create generate token!');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            // $value = $request->bearerToken();
            // $id = (new Parser())->parse($value)->getHeader('jti');
            // $token = $request->user()->tokens->find($id);
            // $token->revoke();
            $request->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });

            return respondSuccess('You have been successfully logged out');
        } catch (\Exception $e) {
            return respondError('Failed to logged out');
        }
    }
}
