<?php

use Faker\Factory as Faker;
use App\Models\Druids;
use App\Repositories\DruidsRepository;

trait MakeDruidsTrait
{
    /**
     * Create fake instance of Druids and save it in database
     *
     * @param array $druidsFields
     * @return Druids
     */
    public function makeDruids($druidsFields = [])
    {
        /** @var DruidsRepository $druidsRepo */
        $druidsRepo = App::make(DruidsRepository::class);
        $theme = $this->fakeDruidsData($druidsFields);
        return $druidsRepo->create($theme);
    }

    /**
     * Get fake instance of Druids
     *
     * @param array $druidsFields
     * @return Druids
     */
    public function fakeDruids($druidsFields = [])
    {
        return new Druids($this->fakeDruidsData($druidsFields));
    }

    /**
     * Get fake data of Druids
     *
     * @param array $postFields
     * @return array
     */
    public function fakeDruidsData($druidsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s'),
            'name' => $fake->word,
            'type' => $fake->word,
            'updated_at' => $fake->date('Y-m-d H:i:s')
        ], $druidsFields);
    }
}
