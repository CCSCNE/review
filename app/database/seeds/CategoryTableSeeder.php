<?php

class CategoryTableSeeder extends Seeder {

    public function run()
    {
        $table = 'categories';

        DB::table($table)->truncate();

        $entries = array(
            array('Papers'),
            array('Posters'),
            array('Tutorials'),
            array('Workshops'),
            array('Panels'),
        );

        $data = array();
        foreach($entries as $entry) {
            Category::create(array('name' => $entry[0]));
        }
    }

}
