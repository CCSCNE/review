<?php

class ReviewerTableSeeder extends Seeder {

    public function run()
    {
        DB::table('reviewers')->truncate();

        $reviewers = User::where('email', 'LIKE', 'reviewer%')->get();
        foreach (Category::all() as $category)
        {
            foreach ($reviewers as $reviewer)
            {
                $category->reviewers()->save($reviewer);
            }
        }
    }

}
