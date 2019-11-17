<?php

use Illuminate\Database\Seeder;

class ErrorReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ErrorReport::class, 10)->create();
    }
}
