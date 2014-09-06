<?php


class SubmissionTableSeeder extends Seeder {

    private $categories;
    private $faker;

    public function run()
    {
        $this->categories = Category::all()->count();
        $this->faker = Faker\Factory::create();
        DB::table('submissions')->truncate();

        foreach (User::where('email', 'LIKE', 'author%')->get() as $author) {
            for ($i=0; $i < 5; $i++)
            {
                $this->generateForUser($author);
            }
        }
    }

    private function generateForUser($user_id) {
        $category = rand(1, $this->categories);
        $title = $this->faker->sentence(5);
        $title = ucwords(substr($title, 0, strlen($title)-1));
        $status = $this->faker->optional(.2)->randomElement(array('closed', 'open', 'reviewing', 'finalizing', 'final'));
        $cat = Category::find($category);
        $result = null;
        if ($cat->status == 'final') {
            $result = $this->faker->randomElement(array('accept', 'reject'));
        } else if ($cat->status = 'finalizing') {
            $result = $this->faker->optional(.5)->randomElement(array('accept', 'reject'));
        } else {
            $result = null;
        }
        Submission::create(array(
            'user_id' => $user_id,
            'category_id' => $category,
            'title' => $title,
            'status' => $status,
            'result' => $result,
        ));
    }

}
