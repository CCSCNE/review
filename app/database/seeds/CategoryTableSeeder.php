<?php

class CategoryTableSeeder extends Seeder {

    public function run()
    {
        DB::table('categories')->truncate();
        Category::create(array('name' => 'Papers'));
        Category::create(array('name' => 'Posters'));
        Category::create(array('name' => 'Workshops'));
    }

}
