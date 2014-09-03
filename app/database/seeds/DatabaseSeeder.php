<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$this->call('UserTableSeeder');
		$this->call('KeywordTableSeeder');
		$this->call('CategoryTableSeeder');
		$this->call('SubmissionTableSeeder');
        $this->call('KeywordableTableSeeder');
        $this->call('ChairTableSeeder');
        $this->call('ReviewerTableSeeder');
        $this->call('ReviewTableSeeder');

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

}
