<?php

class CommentsTableSeeder extends Seeder {

	public function run()
	{
		// Wipe the table clean before populating
		DB::table('comments')->truncate();

		$now = date('Y-m-d H:i:s');

		$comments = array(
			array(
				'post_id' => 6,
				'username' => 'User #1',
				'mail' => 'contact@test.fr',
				'content' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laudantium voluptatibus quae doloribus dolorem earum dicta quasi. Fugit, eligendi, voluptatibus corporis deleniti perferendis accusantium totam harum dolor ab veniam laudantium!",
				'created_at' => $now,
				'updated_at' => $now
			),
			array(
				'post_id' => 6,
				'username' => 'User #2',
				'mail' => 'contact@wordpress.com',
				'content' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laudantium voluptatibus quae doloribus dolorem earum dicta quasi. Fugit, eligendi, voluptatibus corporis deleniti perferendis accusantium totam harum dolor ab veniam laudantium!",
				'created_at' => $now,
				'updated_at' => $now
			),
			array(
				'post_id' => 6,
				'username' => 'User #3',
				'mail' => 'contact@lol.fr',
				'content' => "Hi !\r\nThis is my first comment !",
				'created_at' => $now,
				'updated_at' => $now
			),
		);

		// Run the seeder
		DB::table('comments')->insert($comments);
	}

}
