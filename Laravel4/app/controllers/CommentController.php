<?php

class CommentController extends BaseController {

	public function postCreate(Post $post)
	{
		$input = Input::all();
		$comment = new Comment();
		if ($comment->validate($input)){
			$comment->post_id = $post->id;
			$comment->username = $input['username'];
			$comment->mail = $input['email'];
			$comment->content = $input['content'];
			$comment->save();
			return Redirect::to(URL::route('post', $post->slug).'#comments');
		}else{
			return Redirect::to(URL::route('post', $post->slug).'#comments')->withInput()->withErrors($comment)->with('errors', $comment->errors());
		}
	}

}
