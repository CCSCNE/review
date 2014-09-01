<?php

class ChairTableSeeder extends Seeder {

    public function run()
    {
        $table = 'chairs';
        DB::table($table)->truncate();

        User::find(1)->categoriesChairing()->save(Category::find(1));
        User::find(1)->categoriesChairing()->save(Category::find(2));
        User::find(4)->categoriesChairing()->save(Category::find(1));
        User::find(5)->categoriesChairing()->save(Category::find(2));
        User::find(6)->categoriesChairing()->save(Category::find(3));
    }

}
