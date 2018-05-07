<?php

use App\Models\Druids;
use App\Repositories\DruidsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DruidsRepositoryTest extends TestCase
{
    use MakeDruidsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var DruidsRepository
     */
    protected $druidsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->druidsRepo = App::make(DruidsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateDruids()
    {
        $druids = $this->fakeDruidsData();
        $createdDruids = $this->druidsRepo->create($druids);
        $createdDruids = $createdDruids->toArray();
        $this->assertArrayHasKey('id', $createdDruids);
        $this->assertNotNull($createdDruids['id'], 'Created Druids must have id specified');
        $this->assertNotNull(Druids::find($createdDruids['id']), 'Druids with given id must be in DB');
        $this->assertModelData($druids, $createdDruids);
    }

    /**
     * @test read
     */
    public function testReadDruids()
    {
        $druids = $this->makeDruids();
        $dbDruids = $this->druidsRepo->find($druids->id);
        $dbDruids = $dbDruids->toArray();
        $this->assertModelData($druids->toArray(), $dbDruids);
    }

    /**
     * @test update
     */
    public function testUpdateDruids()
    {
        $druids = $this->makeDruids();
        $fakeDruids = $this->fakeDruidsData();
        $updatedDruids = $this->druidsRepo->update($fakeDruids, $druids->id);
        $this->assertModelData($fakeDruids, $updatedDruids->toArray());
        $dbDruids = $this->druidsRepo->find($druids->id);
        $this->assertModelData($fakeDruids, $dbDruids->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteDruids()
    {
        $druids = $this->makeDruids();
        $resp = $this->druidsRepo->delete($druids->id);
        $this->assertTrue($resp);
        $this->assertNull(Druids::find($druids->id), 'Druids should not exist in DB');
    }
}
