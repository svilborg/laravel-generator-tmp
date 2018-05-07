<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemApiTest extends TestCase
{
    use MakeItemTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateItem()
    {
        $item = $this->fakeItemData();
        $this->json('POST', '/api/v1/items', $item);

        $this->assertApiResponse($item);
    }

    /**
     * @test
     */
    public function testReadItem()
    {
        $item = $this->makeItem();
        $this->json('GET', '/api/v1/items/'.$item->id);

        $this->assertApiResponse($item->toArray());
    }

    /**
     * @test
     */
    public function testUpdateItem()
    {
        $item = $this->makeItem();
        $editedItem = $this->fakeItemData();

        $this->json('PUT', '/api/v1/items/'.$item->id, $editedItem);

        $this->assertApiResponse($editedItem);
    }

    /**
     * @test
     */
    public function testDeleteItem()
    {
        $item = $this->makeItem();
        $this->json('DELETE', '/api/v1/items/'.$item->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/items/'.$item->id);

        $this->assertResponseStatus(404);
    }
}
