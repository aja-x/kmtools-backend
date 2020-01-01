<?php

use Illuminate\Database\Seeder;

class QuestionChoicesTableSeeder extends Seeder
{
    public function run()
    {
        factory(App\QuestionChoice::class, 50)->create();
    }
}
