<?php
namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Auth\Contracts\TokenProviderInterface;

class AccessTokenGuard implements Guard
{
    use GuardHelpers;

    private $inputKey = '';

    private $storageKey = '';

    private $request;

    /**
     *
     * @var TokenProviderInterface
     */
    private $tokenProvider = null;

    public function __construct(TokenProviderInterface $tokenProvider, UserProvider $provider, Request $request, $configuration)
    {
        $this->tokenProvider = $tokenProvider;
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
        $credentialsRetrieve = [
            $this->storageKey => $credentials
        ];

        if ($user = $this->provider->retrieveByCredentials($credentialsRetrieve)) {
            if ($this->provider->validateCredentials($user, $credentials)) {
                $token = $this->tokenProvider->createToken($user->id);

                return $token;
            } else {
                // die("KO");
            }
        }

        return false;
    }

    public function refresh($token)
    {
        $token = $this->tokenProvider->refreshToken($token);

        if ($token) {
            return $token;
        }

        return false;
    }
}