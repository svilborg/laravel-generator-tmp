<?php
namespace App\Auth\TokenGenerator;

use App\Auth\Contracts\TokenGeneratorInterface;

class RandomTokenGenerator implements TokenGeneratorInterface
{

    private $size;

    public function __construct($size = 30)
    {
        $this->size = $size;
    }

    public function generate($payload = [])
    {
        var_dump($payload);
        die;

        return str_random($this->size);
    }
}