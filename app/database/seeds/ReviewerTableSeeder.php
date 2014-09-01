<?php

class ReviewerTableSeeder extends Seeder {

    public function run()
    {
        $table = 'reviewers';
        DB::table($table)->truncate();

        $category = Category::find(1);
        for($i=7; $i<15; $i++) {
            User::find($i)->categoriesReviewing()->save($category);
        }

        $category = Category::find(2);
        for($i=10; $i<19; $i++) {
            User::find($i)->categoriesReviewing()->save($category);
        }
    }

}
