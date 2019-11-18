<?php

use App\Article;
use App\ErrorReport;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Article::class, 10)->create();
        $faker = Faker::create();
        $id_error_report = ErrorReport::all()->pluck('id')->toArray();
        $id_user = User::all()->pluck('id')->toArray();
        for ($i = 0; $i < 10; $i++) {
            Article::create([
                'title' => $faker->sentence(),
                'content' => $faker->paragraph(),
                'last_edited' => $faker->dateTime(),
                'published_date' => $faker->dateTime(),
                'id_error_report' => $faker->randomElement($id_error_report),
                'id_user' => $faker->randomElement($id_user),
            ]);
        }
    }
}
