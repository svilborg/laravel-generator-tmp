<?php
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Item::class, 10)->create()->each(function ($item) {
            echo $item->id;
            echo ",";
        });
    }
}
