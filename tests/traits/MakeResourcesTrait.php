<?php

use Faker\Factory as Faker;
use App\Models\Resources;
use App\Repositories\ResourcesRepository;

trait MakeResourcesTrait
{
    /**
     * Create fake instance of Resources and save it in database
     *
     * @param array $resourcesFields
     * @return Resources
     */
    public function makeResources($resourcesFields = [])
    {
        /** @var ResourcesRepository $resourcesRepo */
        $resourcesRepo = App::make(ResourcesRepository::class);
        $theme = $this->fakeResourcesData($resourcesFields);
        return $resourcesRepo->create($theme);
    }

    /**
     * Get fake instance of Resources
     *
     * @param array $resourcesFields
     * @return Resources
     */
    public function fakeResources($resourcesFields = [])
    {
        return new Resources($this->fakeResourcesData($resourcesFields));
    }

    /**
     * Get fake data of Resources
     *
     * @param array $postFields
     * @return array
     */
    public function fakeResourcesData($resourcesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'tag' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $resourcesFields);
    }
}
