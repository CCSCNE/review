<?php

class ReviewTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('reviews')->truncate();
        $faker = Faker\Factory::create();

        $reviewers = User::where('email', 'LIKE', 'reviewer%')->get();
        foreach ($reviewers as $reviewer)
        {
            foreach ($reviewer->categoriesReviewing as $category)
            {
                foreach ($category->submissions as $submission)
                {
                    $review = new Review;
                    $review->user_id = $reviewer->id;
                    $review->submission_id = $submission->id;
                    $review->save();
                }
            }
        }

        /*
        foreach ($submissions as $submission)
        {
            $reviewers = $submission->category->reviewers()->get();
            print($reviewers->count() . " reviewers\n");
            $revs = array();
            foreach ($reviewers as $reviewer) {
                $revs[] = $reviewer;
            }
            for ($i = 0; $i < 5; $i++)
            {
                try {
                    $reviewer = $faker->unique()->randomElement($revs);
                } catch (Exception $exception) {
                    $faker->unique($reset = true);
                    $reviewer = $faker->unique()->randomElement($revs);
                }
                $review = new Review;
                $review->user_id = $reviewer->id;
                $review->submission_id = $submission->id;
                $review->save();
            }
        }
         */
    }

}
