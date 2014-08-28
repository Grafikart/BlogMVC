<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class BlogTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        // We fill the categories
        foreach(range(1, 10) as $index)
        {
            $name = $faker->sentence(rand(1,4));
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name)
            ]);
        }

        // We fill the posts
        foreach(range(1, 15) as $index)
        {
            $name = $faker->sentence(rand(3,10));
            Post::create([
                "name"        => $name,
                "slug"        => Str::slug($name),
                "content"     => $faker->paragraph(rand(5,10)),
                "user_id"     => 1,
                "category_id" => rand(1,10),
                "created_at"  => $faker->dateTimeThisYear()
            ]);
        }

        // We fill the posts
		foreach(range(1, 100) as $index)
		{
            Comment::create([
                "username"   => $faker->name(),
                "email"       => $faker->email(),
                "post_id"    => rand(1,10),
                "content"    => $faker->paragraph(rand(1,3)),
                "created_at" => $faker->dateTimeThisYear()
            ]);
		}
	}

}