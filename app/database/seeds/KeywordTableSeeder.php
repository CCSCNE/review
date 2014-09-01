<?php

class KeywordTableSeeder extends Seeder {

    public function run()
    {
        DB::table('keywords')->truncate();
        $keywords = array(
            'Algorithms',
            'Programming Languages',
            'Operating Systems',
            'Data Structures',
            'Software Engineering',
            'Databases',
        );
        foreach($keywords as $keyword) {
            Keyword::create(array('keyword'=>$keyword));
        }
    }

}
