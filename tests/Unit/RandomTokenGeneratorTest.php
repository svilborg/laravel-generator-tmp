<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Auth\TokenGenerator\RandomTokenGenerator;

class RandomTokenGeneratorTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $generator = new RandomTokenGenerator();

        $generated = $generator->generate([]);

        $this->assertNotNull($generated);
        $this->assertEquals(30, mb_strlen($generated));
    }
}
