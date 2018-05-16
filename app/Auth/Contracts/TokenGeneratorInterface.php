<?php
namespace App\Auth\Contracts;

interface TokenGeneratorInterface {

    public function generate($payload = []);


}