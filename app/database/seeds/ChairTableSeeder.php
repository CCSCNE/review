<?php

class ChairTableSeeder extends Seeder {

    public function run()
    {
        $table = 'chairs';
        DB::table($table)->truncate();
        $ids = array();
        for ($i = 1; $i <= Category::all()->count(); $i++) {
            $ids[] = $i;
        }
        $user = User::find(1)->categoriesChairing()->sync($ids);
    }

}
