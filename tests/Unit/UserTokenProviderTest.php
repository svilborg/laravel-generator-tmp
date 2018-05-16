<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Auth\TokenGenerator\RandomTokenGenerator;
use App\Auth\TokenGenerator\AESTokenGenerator;
use App\Auth\UserTokenProvider;
use Illuminate\Support\Facades\Hash;

class UserTokenProviderTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRetrieveByIdTest()
    {
        $mockUser = \Mockery::mock(new \App\User());
        $mockUser->shouldReceive('find')
            ->once()
            ->andReturn([]);

        $mockToken = \Mockery::mock(new \App\Token());

        $provider = new UserTokenProvider($mockUser, $mockToken);

        $this->assertEquals([], $provider->retrieveById(1));
    }

    public function testRetrieveByTokenTest()
    {
        $user = new \App\User();
        $user->id = 1;

        $token = new \App\Token();
        $token->user = $user;

        $mockToken = \Mockery::mock(new \App\Token());
        $mockToken->shouldReceive('with')
            ->once()
            ->andReturn($mockToken);
        $mockToken->shouldReceive('where')
            ->once()
            ->andReturn($mockToken);
        $mockToken->shouldReceive('first')
            ->once()
            ->andReturn($token);

        $provider = new UserTokenProvider($user, $mockToken);

        $this->assertEquals($user, $provider->retrieveByToken(1, "test"));
    }

    public function testRetrieveByCredentialsTest()
    {
        $mockUser = \Mockery::mock(new \App\User());
        $mockUser->shouldReceive('where')
            ->once()
            ->andReturn($mockUser);
        $mockUser->shouldReceive('first')
            ->once()
            ->andReturn([]);

        $mockToken = \Mockery::mock(new \App\Token());

        $provider = new UserTokenProvider($mockUser, $mockToken);

        $this->assertEquals([], $provider->retrieveByCredentials([
            "username" => "test"
        ]));
    }

    public function testvalidateCredentialsTest()
    {
        $mockUser = \Mockery::mock(new \App\User());
        $mockUser->shouldReceive('getAuthPassword')
            ->andReturn(Hash::make("test"));

        $mockToken = \Mockery::mock(new \App\Token());

        $provider = new UserTokenProvider($mockUser, $mockToken);

        $this->assertEquals(false, $provider->validateCredentials($mockUser, [
            "password" => "test1"
        ]));

        $this->assertEquals(true, $provider->validateCredentials($mockUser, [
            "password" => "test"
        ]));
    }
}
