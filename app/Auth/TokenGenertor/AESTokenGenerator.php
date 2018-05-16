<?php
namespace App\Auth\TokenGenerator;

use App\Auth\Contracts\TokenGeneratorInterface;

class AESTokenGenerator implements TokenGeneratorInterface
{

    private $password = '';

    private $method = '';

    public function __construct($method = 'aes-256-cbc', $password = null, $iv = null)
    {
        $this->method = $method;
        $this->password = $password ?? "s3cr3tlf38op";
        $this->iv = $iv ?? "385e33f74144tyrd";
    }

    public function generate($payload = [])
    {
        $payload = json_encode($payload);
        $encrypted = base64_encode(openssl_encrypt($payload, $this->method, $this->password, OPENSSL_RAW_DATA, $this->iv));

        return $encrypted;
    }

    public function getPayload($token)
    {
        $decrypted = openssl_decrypt(base64_decode($token), $this->method, $this->password, OPENSSL_RAW_DATA, $this->iv);

        $payload = json_decode($decrypted, true);

        return $payload;
    }
}