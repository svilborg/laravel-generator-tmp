<?php

use Faker\Factory as Faker;
use App\Models\Item;
use App\Repositories\ItemRepository;

trait MakeItemTrait
{
    /**
     * Create fake instance of Item and save it in database
     *
     * @param array $itemFields
     * @return Item
     */
    public function makeItem($itemFields = [])
    {
        /** @var ItemRepository $itemRepo */
        $itemRepo = App::make(ItemRepository::class);
        $theme = $this->fakeItemData($itemFields);
        return $itemRepo->create($theme);
    }

    /**
     * Get fake instance of Item
     *
     * @param array $itemFields
     * @return Item
     */
    public function fakeItem($itemFields = [])
    {
        return new Item($this->fakeItemData($itemFields));
    }

    /**
     * Get fake data of Item
     *
     * @param array $postFields
     * @return array
     */
    public function fakeItemData($itemFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $itemFields);
    }
}
