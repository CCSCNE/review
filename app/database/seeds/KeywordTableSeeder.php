<?php

class KeywordTableSeeder extends Seeder {

    public function run()
    {
        DB::table('keywords')->truncate();
        Keyword::create(array('keyword' => 'Algorithms'));
        Keyword::create(array('keyword' => 'Programming Languages'));
        Keyword::create(array('keyword' => 'Operating Systems'));
        Keyword::create(array('keyword' => 'Data Structures'));
        Keyword::create(array('keyword' => 'Software Engineering'));
    }

}
