<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DruidsApiTest extends TestCase
{
    use MakeDruidsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateDruids()
    {
        $druids = $this->fakeDruidsData();
        $this->json('POST', '/api/v1/druids', $druids);

        $this->assertApiResponse($druids);
    }

    /**
     * @test
     */
    public function testReadDruids()
    {
        $druids = $this->makeDruids();
        $this->json('GET', '/api/v1/druids/'.$druids->id);

        $this->assertApiResponse($druids->toArray());
    }

    /**
     * @test
     */
    public function testUpdateDruids()
    {
        $druids = $this->makeDruids();
        $editedDruids = $this->fakeDruidsData();

        $this->json('PUT', '/api/v1/druids/'.$druids->id, $editedDruids);

        $this->assertApiResponse($editedDruids);
    }

    /**
     * @test
     */
    public function testDeleteDruids()
    {
        $druids = $this->makeDruids();
        $this->json('DELETE', '/api/v1/druids/'.$druids->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/druids/'.$druids->id);

        $this->assertResponseStatus(404);
    }
}
