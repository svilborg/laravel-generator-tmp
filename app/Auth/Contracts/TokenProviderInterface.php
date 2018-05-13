<?php
namespace App\Auth\Contracts;

interface TokenProviderInterface {

    public function createToken($user_id);

    public function refreshToken($user_id);

}