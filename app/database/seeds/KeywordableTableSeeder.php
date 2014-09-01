<?php

class KeywordableTableSeeder extends Seeder {

    public function run()
    {
        $table = 'keywordables';
        DB::table($table)->truncate();

        $entries = array(
            array(1, 1),
            array(1, 2),
            array(1, 3),
            array(1, 4),
            array(1, 5),
            array(2, 1),
            array(2, 2),
            array(2, 3),
            array(2, 4),
            array(2, 5),
            array(3, 1),
            array(3, 3),
            array(3, 5),
            array(4, 2),
            array(4, 4),
        );

        foreach($entries as $entry) {
            Category::find($entry[0])->keywords()->save(Keyword::find($entry[1]));
        }
    }

}
