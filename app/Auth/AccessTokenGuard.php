<?php

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccessTokenGuard implements Guard
{
    use GuardHelpers;

    private $inputKey = '';

    private $storageKey = '';

    private $request;

    public function __construct(UserProvider $provider, Request $request, $configuration)
    {
        $this->provider = $provider;
        $this->request = $request;
        // key to check in request
        $this->inputKey = isset($configuration['input_key']) ? $configuration['input_key'] : 'access_token';
        // key to check in database
        $this->storageKey = isset($configuration['storage_key']) ? $configuration['storage_key'] : 'access_token';
    }

    public function user()
    {
        if (! is_null($this->user)) {
            return $this->user;
        }
        $user = null;
        // retrieve via token
        $token = $this->getTokenForRequest();
        if (! empty($token)) {
            // the token was found, how you want to pass?
            $user = $this->provider->retrieveByToken($this->storageKey, $token);
        }
        return $this->user = $user;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest()
    {
        $token = $this->request->query($this->inputKey);
        if (empty($token)) {
            $token = $this->request->input($this->inputKey);
        }
        if (empty($token)) {
            $token = $this->request->bearerToken();
        }
        return $token;
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {

        if (empty($credentials[$this->inputKey])) {
            return false;
        }
        $credentials = [
            $this->storageKey => $credentials[$this->inputKey]
        ];

        if ($user = $this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }

    public function attempt(array $credentials = [])
    {
        $credentials = [
            $this->storageKey => $credentials
        ];

        if ($user = $this->provider->retrieveByCredentials($credentials)) {
            $token = $this->createToken($user->id);

            return $token;
        }

        return false;
    }

    private function createToken($user_id) {
        $verification_code = str_random(30); // Generate verification code

        DB::table('tokens')->insert([
            'user_id' => $user_id,
            'access_token' => $verification_code,
            'refresh_token' => "",
            'expires_in' => date("Y-m-d H:i:s", time() + 24*60*60),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        return $verification_code;
    }
}