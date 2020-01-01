<?php

use Illuminate\Database\Seeder;

class UserKmAttributesTableSeeder extends Seeder
{
    public function run()
    {
        factory(App\UserKmAttribute::class, 10)->create();
    }
}
