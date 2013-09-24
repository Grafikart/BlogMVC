<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name', 255);
			$table->string('slug', 255);
			$table->integer('post_count')->unsigned();

			$table->timestamps();
			$table->softDeletes();
		});
	
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->string('name', 255);
			$table->string('slug', 255);
			$table->longText('content');

			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('comments', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('post_id')->unsigned();
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
			$table->string('username', 255);
			$table->string('mail', 255);
			$table->mediumText('content');

			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('posts', function($table) {
            $table->dropForeign('posts_category_id_foreign');
            $table->dropForeign('posts_user_id_foreign');
        });
        Schema::table('comments', function($table) {
            $table->dropForeign('comments_post_id_foreign');
        });
		Schema::drop('categories');
		Schema::drop('posts');
		Schema::drop('comments');
	}

}
