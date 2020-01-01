<?php

use App\TestCategory;
use Illuminate\Database\Seeder;

class TestCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        TestCategory::create([
            'name' => 'pre test',
        ]);
        TestCategory::create([
            'name' => 'post test',
        ]);
    }
}
