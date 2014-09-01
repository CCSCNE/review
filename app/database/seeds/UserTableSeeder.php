<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->truncate();

        $user = User::create(array(
            'email' => 'hjackson@wne.edu',
            'password' => Hash::make('asdfasdf'),
        ));

        $faker = Faker\Factory::create();
        for ($i=0; $i<100; $i++)
        {
            $user = User::create(array(
                'email' => $faker->email,
                'password' => Hash::make($faker->word),
            ));
        }
    }

}
