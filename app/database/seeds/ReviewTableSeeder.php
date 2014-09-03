<?php

class ReviewTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('reviews')->truncate();

        $submissions = Submission::all()->count();
        $users = User::all()->count();

        $subids = array();
        for($subid = 1; $subid <= $submissions; $subid++)
        {
            $subids[] = $subid;
        }

        for($user = 1; $user <= $users; $user++)
        {
            $sids = $subids;
            for ($i = 0; $i < 3; $i++)
            {
                $random = rand(0, count($sids)-1);
                $sid = $sids[$random];
                unset($sids[$random]);
                $sids = array_values($sids);
                $review = new Review;
                $review->user_id = $user;
                $review->submission_id = $sid;
                $review->save();
            }
        }
    }

}
