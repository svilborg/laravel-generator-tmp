<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResourcesApiTest extends TestCase
{
    use MakeResourcesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateResources()
    {
        $resources = $this->fakeResourcesData();
        $this->json('POST', '/api/v1/resources', $resources);

        $this->assertApiResponse($resources);
    }

    /**
     * @test
     */
    public function testReadResources()
    {
        $resources = $this->makeResources();
        $this->json('GET', '/api/v1/resources/'.$resources->id);

        $this->assertApiResponse($resources->toArray());
    }

    /**
     * @test
     */
    public function testUpdateResources()
    {
        $resources = $this->makeResources();
        $editedResources = $this->fakeResourcesData();

        $this->json('PUT', '/api/v1/resources/'.$resources->id, $editedResources);

        $this->assertApiResponse($editedResources);
    }

    /**
     * @test
     */
    public function testDeleteResources()
    {
        $resources = $this->makeResources();
        $this->json('DELETE', '/api/v1/resources/'.$resources->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/resources/'.$resources->id);

        $this->assertResponseStatus(404);
    }
}
