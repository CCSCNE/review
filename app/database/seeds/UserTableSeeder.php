<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('users')->truncate();

        // Random Authors
        $this->randomUsers('author', 5);

        // Random Reviewers
        $this->randomUsers('reviewer', 5);

        // Random Chairs
        $this->randomUsers('chair', 5);
    }

    function randomUsers($type, $n) {
        for ($i=0; $i<$n; $i++) {
            $email = "$type$i@demo.edu";
            $password = Hash::make($email);
            User::create(array(
                'email' => $email,
                'password' => $password,
            ));
        }
    }

}
