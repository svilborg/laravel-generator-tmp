<?php

use Faker\Factory as Faker;
use App\Models\Units;
use App\Repositories\UnitsRepository;

trait MakeUnitsTrait
{
    /**
     * Create fake instance of Units and save it in database
     *
     * @param array $unitsFields
     * @return Units
     */
    public function makeUnits($unitsFields = [])
    {
        /** @var UnitsRepository $unitsRepo */
        $unitsRepo = App::make(UnitsRepository::class);
        $theme = $this->fakeUnitsData($unitsFields);
        return $unitsRepo->create($theme);
    }

    /**
     * Get fake instance of Units
     *
     * @param array $unitsFields
     * @return Units
     */
    public function fakeUnits($unitsFields = [])
    {
        return new Units($this->fakeUnitsData($unitsFields));
    }

    /**
     * Get fake data of Units
     *
     * @param array $postFields
     * @return array
     */
    public function fakeUnitsData($unitsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $unitsFields);
    }
}
