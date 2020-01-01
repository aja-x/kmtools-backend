<?php

use Illuminate\Database\Seeder;

class TestHistoriesTableSeeder extends Seeder
{
    public function run()
    {
        factory(App\TestHistory::class, 10)->create();
    }
}
