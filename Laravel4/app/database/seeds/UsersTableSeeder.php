<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Wipe the table clean before populating
		DB::table('users')->truncate();

		$now = date('Y-m-d H:i:s');

		$users = array(
			array(
				'username' => 'admin',
				'password' => Hash::make('admin'),
				'created_at' => $now,
				'updated_at' => $now
			),
		);

		// Run the seeder
		DB::table('users')->insert($users);
	}

}
