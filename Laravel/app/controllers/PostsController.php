<?php

class PostsController extends BaseController {

    public function index()
    {
        $posts = Post::with('category', 'user')->paginate(5);
        $this->layout->nest('content', 'posts.index', compact('posts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = Post::with('category', 'user')->where('category_id', $category->id)->paginate(5);
        $this->layout->nest('content', 'posts.index', compact('posts'));
    }

    public function author($user_id)
    {
        $posts = Post::with('category', 'user')->where('user_id', $user_id)->paginate(5);
        $this->layout->nest('content', 'posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::with('category', 'user')->where('slug', $slug)->firstOrFail();
        $this->layout->nest('content', 'posts.show', compact('post'));
    }

}
