<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6',
        ]);

        $input = $request->only('email', 'password');

        $token = null;

        if (!$token = auth()->attempt($input)) {
            return response([
                'errors' => 'Invalid Email or Password',
            ], 401);
        }

        return response([
            'data' => $this->getUser(),
            'meta' => $this->respondWithToken($token),
        ],200);
    }

    /**
     * Register a User.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request) {

        $request->validate([
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create(array_merge(
            $request->toArray(),
            ['password' => bcrypt($request->password)]
        ));

        $input = $request->only('email', 'password');

        $token = auth()->attempt($input);

        return response()->json([
            'data' => $this->getUser(),
            'meta' => $this->respondWithToken($token),
        ],200);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return Response
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * Get the User data.
     *
     * @return Response
     */
    public function me()
    {
        return response([
            'data' => $this->getUser(),
        ],200);
    }

    /**
     * Get the authenticated User.
     *
     * @return object
     */
    public function getUser()
    {
        return [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email
        ];
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return object
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
