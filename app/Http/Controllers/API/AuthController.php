<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use App\Http\Controllers\AppBaseController;

class AuthController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $credentials = $request->only('name', 'email', 'password');

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users'
        ];

        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->messages()
            ]);
        }

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = Auth::guard("api_token")->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'error' => 'We cant find an account with this credentials.'
                ], 401);
            }
        } catch (\Exception $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'success' => false,
                'error' => 'Failed to login, please try again.'
            ], 500);
        }

        return $this->respondWithToken($token);
    }

    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->messages()
            ]);
        }

        try {

            // attempt to verify the credentials and create a token for the user
            if (! $token = Auth::guard("api_token")->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'error' => 'We cant find an account with this credentials.'
                ], 401);
            }

        } catch (\Exception $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'success' => false,
                'error' => 'Failed to login, please try again.' . $e->getMessage()
            ], 500);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

//     /**
//      * API Refresh, on success return JWT Auth token
//      *
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function refresh(Request $request)
//     {
//         $token = $request->get('token');

//         if (! $token) {
//             return response()->json([
//                 'success' => false,
//                 'error' => "Missing Token"
//             ]);
//         }

//         try {
//             // attempt to verify the credentials and create a token for the user
//             if (! $retoken = Auth::guard('api')->refresh($token)) {
//                 return response()->json([
//                     'success' => false,
//                     'error' => 'Wrong Token.'
//                 ], 401);
//             }
//         } catch (JWTException $e) {
//             // something went wrong whilst attempting to encode the token
//             return response()->json([
//                 'success' => false,
//                 'error' => 'Token Error : ' . $e->getMessage()
//             ], 500);
//         }

//         // all good so return the token
//         return response()->json([
//             'success' => true,
//             'data' => [
//                 'token' => $retoken
//             ]
//         ]);
//     }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => 60
                ]
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }




}