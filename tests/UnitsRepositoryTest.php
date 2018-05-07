<?php

use App\Models\Units;
use App\Repositories\UnitsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UnitsRepositoryTest extends TestCase
{
    use MakeUnitsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var UnitsRepository
     */
    protected $unitsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->unitsRepo = App::make(UnitsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateUnits()
    {
        $units = $this->fakeUnitsData();
        $createdUnits = $this->unitsRepo->create($units);
        $createdUnits = $createdUnits->toArray();
        $this->assertArrayHasKey('id', $createdUnits);
        $this->assertNotNull($createdUnits['id'], 'Created Units must have id specified');
        $this->assertNotNull(Units::find($createdUnits['id']), 'Units with given id must be in DB');
        $this->assertModelData($units, $createdUnits);
    }

    /**
     * @test read
     */
    public function testReadUnits()
    {
        $units = $this->makeUnits();
        $dbUnits = $this->unitsRepo->find($units->id);
        $dbUnits = $dbUnits->toArray();
        $this->assertModelData($units->toArray(), $dbUnits);
    }

    /**
     * @test update
     */
    public function testUpdateUnits()
    {
        $units = $this->makeUnits();
        $fakeUnits = $this->fakeUnitsData();
        $updatedUnits = $this->unitsRepo->update($fakeUnits, $units->id);
        $this->assertModelData($fakeUnits, $updatedUnits->toArray());
        $dbUnits = $this->unitsRepo->find($units->id);
        $this->assertModelData($fakeUnits, $dbUnits->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteUnits()
    {
        $units = $this->makeUnits();
        $resp = $this->unitsRepo->delete($units->id);
        $this->assertTrue($resp);
        $this->assertNull(Units::find($units->id), 'Units should not exist in DB');
    }
}
