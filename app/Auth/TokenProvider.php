<?php
namespace App\Auth;

use App\Auth\Contracts\TokenProviderInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Auth\Contracts\TokenGeneratorInterface;
use App\Auth\TokenGenerator\RandomTokenGenerator;

class TokenProvider implements TokenProviderInterface
{

    private $expires_in = 24 * 60 * 60;

    private $tokenGenerator = null;

    public function __construct(TokenGeneratorInterface $tokenGenerator = null) {
        $this->tokenGenerator = $tokenGenerator ?? new RandomTokenGenerator();
    }

    public function createToken($user_id)
    {
        $verification_code = $this->tokenGenerator->generate(); // Generate verification code
        $refresh_code = $this->tokenGenerator->generate();

        $token = DB::table('tokens')->insert([
            'user_id' => $user_id,
            'access_token' => $verification_code,
            'refresh_token' => $refresh_code,
            'expires_in' => date("Y-m-d H:i:s", time() + $this->expires_in),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return [
            'access_token' => $verification_code,
            'refresh_token' => $refresh_code,
            'expires_in' => $this->expires_in,
            'token_type' => 'bearer'
        ];
    }

    public function refreshToken($refreshToken)
    {
        $old = DB::table('tokens')->where('refresh_token', $refreshToken)->first();

        if ($old) {
            // Invalidate OLD
            DB::table("tokens")->where(["id" => $old->id])->update(["expires_in" => Carbon::yesterday()]);

            // return NEW
            return $this->createToken($old->user_id);
        }
    }
}