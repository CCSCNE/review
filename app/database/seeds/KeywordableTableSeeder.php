<?php

class KeywordableTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('keywordables')->truncate();

        $users = User::all()->count();
        $categories = Category::all()->count();
        $submissions = Submission::all()->count();
        $keywords = Keyword::all()->count();

        for ($category = 1; $category <= $categories; $category++)
        {
            for ($i = 1; $i <= $keywords; $i++)
            {
                Category::find($category)->keywords()->save(Keyword::find($i));
            }
        }

        $keyword_ids = array();
        for ($i = 1; $i <= $keywords; $i++) {
            $keyword_ids[] = $i;
        }

        for ($i = 1; $i <= $submissions; $i++) {
            $kids = $keyword_ids;
            for ($j = 0; $j < 3; $j++) {
                $random = rand(0, count($kids)-1);
                $kid = $kids[$random];
                unset($kids[$random]);
                $kids = array_values($kids);
                Submission::find($i)->keywords()->save(Keyword::find($kid));
            }
        }
        
        for ($i = 1; $i <= $users; $i++) {
            $kids = $keyword_ids;
            for ($j = 0; $j < 3; $j++) {
                $random = rand(0, count($kids)-1);
                $kid = $kids[$random];
                unset($kids[$random]);
                $kids = array_values($kids);
                User::find($i)->keywords()->save(Keyword::find($kid));
            }
        }
    }

}
