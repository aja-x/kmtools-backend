<?php

use App\InterestCategory;
use Illuminate\Database\Seeder;

class InterestCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        InterestCategory::create([
            'name' => 'Frontend',
        ]);
        InterestCategory::create([
            'name' => 'Backend',
        ]);
        InterestCategory::create([
            'name' => 'UI/UX',
        ]);
    }
}
