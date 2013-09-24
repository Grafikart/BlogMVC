<?php

class BlogController extends BaseController {

	public function getIndex()
	{
		$data = array();

		$data['posts'] = Post::orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(5);

        return View::make('blog.index', $data);
	}

	public function getPost(Post $post){
		$data = array();

		$data['post'] = $post;

		$data['nb_comments'] = $post->comments->count();

		$data['comments'] = $post->comments;

		return View::make('blog.post', $data);
	}

	public function getCategory(Category $category){
		$data = array();

		$data['category'] = $category;

		$data['posts'] = Post::where('category_id', $category->id)->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(5);

        return View::make('blog.category', $data);
	}

	public function getAuthor(User $author){
		$data = array();

		$data['author'] = $author;

		$data['posts'] = Post::where('user_id', $author->id)->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(5);

        return View::make('blog.author', $data);
	}

}