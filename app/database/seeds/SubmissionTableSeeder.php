<?php

class SubmissionTableSeeder extends Seeder {

    public function run()
    {
        $table = 'submissions';
        DB::table($table)->truncate();

        $entries = array(
            array(3, 1, 'Title One'),
            array(3, 2, 'Title Two'),
            array(2, 1, 'Title Three'),
            array(2, 1, 'Title Four'),
            array(2, 3, 'Title Five'),
        );

        $data = array();
        foreach($entries as $entry) {
            Submission::create(array(
                'user_id' => $entry[0],
                'category_id' => $entry[1],
                'title' => $entry[2],
            ));
        }
    }

}
