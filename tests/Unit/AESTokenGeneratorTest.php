<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Auth\TokenGenerator\RandomTokenGenerator;
use App\Auth\TokenGenerator\AESTokenGenerator;

class AESTokenGeneratorTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $generator = new AESTokenGenerator();

        $generated = $generator->generate([
            "one" => "two"
        ]);
        $pl = $generator->getPayload($generated);

        $this->assertNotNull($generated);
        $this->assertEquals([
            "one" => "two"
        ], $pl);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEmptyPayload()
    {
        $generator = new AESTokenGenerator();

        $generated = $generator->generate([
        ]);
        $pl = $generator->getPayload($generated);

        $this->assertNotNull($generated);
        $this->assertEquals([
        ], $pl);
    }
}
