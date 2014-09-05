<?php

class CategoryTableSeeder extends Seeder {

    public function run()
    {
        DB::table('categories')->truncate();
        Category::create(array('name' => 'Papers', 'status'=>'open'));
        Category::create(array('name' => 'Posters', 'status'=>'reviewing'));
        Category::create(array('name' => 'Workshops', 'status'=>'finalizing'));
        Category::create(array('name' => 'Panels', 'status'=>'final'));
        Category::create(array('name' => 'Demos', 'status'=>'closed'));
    }

}
