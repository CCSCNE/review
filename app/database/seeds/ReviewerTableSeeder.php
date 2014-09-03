<?php

class ReviewerTableSeeder extends Seeder {

    public function run()
    {
        DB::table('reviewers')->truncate();

        $categories = Category::all()->count();
        $users = User::all()->count();

        $cat_ids = array();
        for($i=1; $i <= $categories; $i++) {
            $cat_ids[] = $i;
        }

        for($user = 1; $user <= $users; $user++) {
            $cids = $cat_ids;
            for ($i = 0; $i < 2; $i++) {
                $random = rand(0, count($cids)-1);
                $cat = $cids[$random];
                unset($cids[$random]);
                $cids = array_values($cids);
                Category::find($cat)->reviewers()->save(User::find($user));
            }
        }
    }

}
