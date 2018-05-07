<?php

use App\Models\Items;
use App\Repositories\ItemsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemsRepositoryTest extends TestCase
{
    use MakeItemsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ItemsRepository
     */
    protected $itemsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->itemsRepo = App::make(ItemsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateItems()
    {
        $items = $this->fakeItemsData();
        $createdItems = $this->itemsRepo->create($items);
        $createdItems = $createdItems->toArray();
        $this->assertArrayHasKey('id', $createdItems);
        $this->assertNotNull($createdItems['id'], 'Created Items must have id specified');
        $this->assertNotNull(Items::find($createdItems['id']), 'Items with given id must be in DB');
        $this->assertModelData($items, $createdItems);
    }

    /**
     * @test read
     */
    public function testReadItems()
    {
        $items = $this->makeItems();
        $dbItems = $this->itemsRepo->find($items->id);
        $dbItems = $dbItems->toArray();
        $this->assertModelData($items->toArray(), $dbItems);
    }

    /**
     * @test update
     */
    public function testUpdateItems()
    {
        $items = $this->makeItems();
        $fakeItems = $this->fakeItemsData();
        $updatedItems = $this->itemsRepo->update($fakeItems, $items->id);
        $this->assertModelData($fakeItems, $updatedItems->toArray());
        $dbItems = $this->itemsRepo->find($items->id);
        $this->assertModelData($fakeItems, $dbItems->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteItems()
    {
        $items = $this->makeItems();
        $resp = $this->itemsRepo->delete($items->id);
        $this->assertTrue($resp);
        $this->assertNull(Items::find($items->id), 'Items should not exist in DB');
    }
}
