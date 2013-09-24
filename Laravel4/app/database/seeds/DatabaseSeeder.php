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
		
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$this->call('UsersTableSeeder');
		$this->command->info('Users table seeded !');

		$this->call('CategoriesTableSeeder');
		$this->command->info('Categories table seeded !');

		$this->call('PostsTableSeeder');
		$this->command->info('Posts table seeded !');

		$this->call('CommentsTableSeeder');
		$this->command->info('Comments table seeded !');
		
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

}