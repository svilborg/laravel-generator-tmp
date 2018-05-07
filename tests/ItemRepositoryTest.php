<?php

use App\Models\Item;
use App\Repositories\ItemRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemRepositoryTest extends TestCase
{
    use MakeItemTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ItemRepository
     */
    protected $itemRepo;

    public function setUp()
    {
        parent::setUp();
        $this->itemRepo = App::make(ItemRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateItem()
    {
        $item = $this->fakeItemData();
        $createdItem = $this->itemRepo->create($item);
        $createdItem = $createdItem->toArray();
        $this->assertArrayHasKey('id', $createdItem);
        $this->assertNotNull($createdItem['id'], 'Created Item must have id specified');
        $this->assertNotNull(Item::find($createdItem['id']), 'Item with given id must be in DB');
        $this->assertModelData($item, $createdItem);
    }

    /**
     * @test read
     */
    public function testReadItem()
    {
        $item = $this->makeItem();
        $dbItem = $this->itemRepo->find($item->id);
        $dbItem = $dbItem->toArray();
        $this->assertModelData($item->toArray(), $dbItem);
    }

    /**
     * @test update
     */
    public function testUpdateItem()
    {
        $item = $this->makeItem();
        $fakeItem = $this->fakeItemData();
        $updatedItem = $this->itemRepo->update($fakeItem, $item->id);
        $this->assertModelData($fakeItem, $updatedItem->toArray());
        $dbItem = $this->itemRepo->find($item->id);
        $this->assertModelData($fakeItem, $dbItem->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteItem()
    {
        $item = $this->makeItem();
        $resp = $this->itemRepo->delete($item->id);
        $this->assertTrue($resp);
        $this->assertNull(Item::find($item->id), 'Item should not exist in DB');
    }
}
