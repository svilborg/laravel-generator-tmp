<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

/**
 * Class ItemController
 *
 * @package App\Http\Controllers\API
 */
class LoginAPIController extends AppBaseController
{

    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function index(Request $request)
    {
        $d = $this->userRepository->findWhere([
            "email" => $request->get("email")
        ]);

        if (! $d->isEmpty()) {
            // proxy
            return $this->proxy('password', [
                'username' => $request->get("email"),
                'password' => $request->get("password")
            ]);
        }

        var_dump($d->isEmpty());
        die();
    }

    /**
     * Proxy a request to the OAuth server.
     *
     * @param string $grantType
     *            what type of grant type should be proxied
     * @param array $data
     *            the data to send to the server
     */
    public function proxy($grantType, array $data = [])
    {
        $data = array_merge($data, [
            'client_id' => '3',
            'client_secret' => 'fWSn2MuCq3sIcN35bSe4Qq1fpreKi0ndKVS2rZh4',
            'grant_type' => 'password',
            'scope' => '*'
        ]);

        $result = $this->getAccessToken($data);
        if (! $result) {
            throw new \Exception("Unauthorized");
        }

        // Create a refresh token cookie
//         $this->cookie->queue(self::REFRESH_TOKEN, $data["refresh_token"], 864000, null, null, false, true); // HttpOnly

        return [
            'access_token' => $data["access_token"],
            'expires_in' => $data["expires_in"]
        ];
    }

    private function getAccessToken($data)
    {
        $http = new Client();

        try {
            $response = $http->post('http://localhost:8000/oauth/token', [
                'form_params' => $data
            ]);

            $result = json_decode((string) $response->getBody(), true);
        } catch (\Exception $e) {
            return null;
        }
        return $result;
    }
}