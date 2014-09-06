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

        foreach(User::where('email', 'LIKE', 'chair%')->get() as $chair)
        {
            $chair->categoriesChairing()->sync($ids);
        }
    }

}
