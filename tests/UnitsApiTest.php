<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UnitsApiTest extends TestCase
{
    use MakeUnitsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateUnits()
    {
        $units = $this->fakeUnitsData();
        $this->json('POST', '/api/v1/units', $units);

        $this->assertApiResponse($units);
    }

    /**
     * @test
     */
    public function testReadUnits()
    {
        $units = $this->makeUnits();
        $this->json('GET', '/api/v1/units/'.$units->id);

        $this->assertApiResponse($units->toArray());
    }

    /**
     * @test
     */
    public function testUpdateUnits()
    {
        $units = $this->makeUnits();
        $editedUnits = $this->fakeUnitsData();

        $this->json('PUT', '/api/v1/units/'.$units->id, $editedUnits);

        $this->assertApiResponse($editedUnits);
    }

    /**
     * @test
     */
    public function testDeleteUnits()
    {
        $units = $this->makeUnits();
        $this->json('DELETE', '/api/v1/units/'.$units->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/units/'.$units->id);

        $this->assertResponseStatus(404);
    }
}
