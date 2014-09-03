<?php

class SubmissionTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('submissions')->truncate();

        $users = User::all()->count();
        $categories = Category::all()->count();
        for ($i = 0; $i < 30; $i++) {
            $user = rand(1, $users);
            $category = rand(1, $categories);
            $title = $faker->sentence(5);
            $title = ucwords(substr($title, 0, strlen($title)-1));
            Submission::create(array(
                'user_id' => $user,
                'category_id' => $category,
                'title' => $title
            ));
        }
    }

}
