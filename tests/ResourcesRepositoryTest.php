<?php

use App\Models\Resources;
use App\Repositories\ResourcesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResourcesRepositoryTest extends TestCase
{
    use MakeResourcesTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ResourcesRepository
     */
    protected $resourcesRepo;

    public function setUp()
    {
        parent::setUp();
        $this->resourcesRepo = App::make(ResourcesRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateResources()
    {
        $resources = $this->fakeResourcesData();
        $createdResources = $this->resourcesRepo->create($resources);
        $createdResources = $createdResources->toArray();
        $this->assertArrayHasKey('id', $createdResources);
        $this->assertNotNull($createdResources['id'], 'Created Resources must have id specified');
        $this->assertNotNull(Resources::find($createdResources['id']), 'Resources with given id must be in DB');
        $this->assertModelData($resources, $createdResources);
    }

    /**
     * @test read
     */
    public function testReadResources()
    {
        $resources = $this->makeResources();
        $dbResources = $this->resourcesRepo->find($resources->id);
        $dbResources = $dbResources->toArray();
        $this->assertModelData($resources->toArray(), $dbResources);
    }

    /**
     * @test update
     */
    public function testUpdateResources()
    {
        $resources = $this->makeResources();
        $fakeResources = $this->fakeResourcesData();
        $updatedResources = $this->resourcesRepo->update($fakeResources, $resources->id);
        $this->assertModelData($fakeResources, $updatedResources->toArray());
        $dbResources = $this->resourcesRepo->find($resources->id);
        $this->assertModelData($fakeResources, $dbResources->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteResources()
    {
        $resources = $this->makeResources();
        $resp = $this->resourcesRepo->delete($resources->id);
        $this->assertTrue($resp);
        $this->assertNull(Resources::find($resources->id), 'Resources should not exist in DB');
    }
}
