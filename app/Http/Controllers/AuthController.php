<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Transformers\UserTransformer;
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
            if(!User::where('email', $request->email)->first()){
                return response([
                    "errors"=>
                    ["email"=> "The email do not match our records."]
                ], 401);
            }else{
                return response([
                    "errors"=>
                    ["password"=> "The password do not match our records."]
                ], 401);
            }
        }

        $user = auth()->user();

        return fractal($user, new UserTransformer())
        ->addMeta($this->respondWithToken($token))
        ->respond(200);
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

        $user = auth()->user();

        return fractal($user, new UserTransformer())
        ->addMeta($this->respondWithToken($token))
        ->respond(201);
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
        $user = auth()->user();

        return fractal($user, new UserTransformer())
        ->respond(200);
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
