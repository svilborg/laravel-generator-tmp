<?php

use Faker\Factory as Faker;
use App\Models\Items;
use App\Repositories\ItemsRepository;

trait MakeItemsTrait
{
    /**
     * Create fake instance of Items and save it in database
     *
     * @param array $itemsFields
     * @return Items
     */
    public function makeItems($itemsFields = [])
    {
        /** @var ItemsRepository $itemsRepo */
        $itemsRepo = App::make(ItemsRepository::class);
        $theme = $this->fakeItemsData($itemsFields);
        return $itemsRepo->create($theme);
    }

    /**
     * Get fake instance of Items
     *
     * @param array $itemsFields
     * @return Items
     */
    public function fakeItems($itemsFields = [])
    {
        return new Items($this->fakeItemsData($itemsFields));
    }

    /**
     * Get fake data of Items
     *
     * @param array $postFields
     * @return array
     */
    public function fakeItemsData($itemsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'title' => $fake->word,
            'description' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $itemsFields);
    }
}
