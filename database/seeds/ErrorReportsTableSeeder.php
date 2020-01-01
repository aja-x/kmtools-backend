<?php

use Illuminate\Database\Seeder;

class ErrorReportsTableSeeder extends Seeder
{
    public function run()
    {
        factory(App\ErrorReport::class, 10)->create();
    }
}
