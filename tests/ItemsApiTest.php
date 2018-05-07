<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemsApiTest extends TestCase
{
    use MakeItemsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateItems()
    {
        $items = $this->fakeItemsData();
        $this->json('POST', '/api/v1/items', $items);

        $this->assertApiResponse($items);
    }

    /**
     * @test
     */
    public function testReadItems()
    {
        $items = $this->makeItems();
        $this->json('GET', '/api/v1/items/'.$items->id);

        $this->assertApiResponse($items->toArray());
    }

    /**
     * @test
     */
    public function testUpdateItems()
    {
        $items = $this->makeItems();
        $editedItems = $this->fakeItemsData();

        $this->json('PUT', '/api/v1/items/'.$items->id, $editedItems);

        $this->assertApiResponse($editedItems);
    }

    /**
     * @test
     */
    public function testDeleteItems()
    {
        $items = $this->makeItems();
        $this->json('DELETE', '/api/v1/items/'.$items->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/items/'.$items->id);

        $this->assertResponseStatus(404);
    }
}
