<?php

class CategoriesTableSeeder extends Seeder {

	public function run()
	{
		// Wipe the table clean before populating
		DB::table('categories')->truncate();

		$now = date('Y-m-d H:i:s');

		$categories = array(
			array(
				'name' => 'Category #1',
				'slug' => 'category-1',
				'post_count' => 2,
				'created_at' => $now,
				'updated_at' => $now
			),
			array(
				'name' => 'Category #2',
				'slug' => 'category-2',
				'post_count' => 2,
				'created_at' => $now,
				'updated_at' => $now
			),
			array(
				'name' => 'Category #3',
				'slug' => 'category-3',
				'post_count' => 2,
				'created_at' => $now,
				'updated_at' => $now
			),
		);

		// Run the seeder
		DB::table('categories')->insert($categories);
	}

}
