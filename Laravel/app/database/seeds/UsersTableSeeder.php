<?php
class UsersTableSeeder extends Seeder {

	public function run()
	{
		User::create([
            'username' => 'admin',
            'password' =>  Hash::make('admin')
		]);
	}

}