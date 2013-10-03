@extends('layouts.master')

@section('content')

<div class="container">

    <h1>Edit post</h1>

    <p><a href="{{ URL::route('admin.index') }}">< Back to posts</a></p>

    {{ Form::open(["method" => "PUT" , "route" => ["admin.posts.update" , $post->id] , "id" => "PostAdminEditForm"]) }}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group required">
                <label for="PostName">Name :</label>
                {{ Form::text("name" , isset($post->name) ? $post->name : Input::old("name") , ["class" => "form-control" , "maxlength" => "255" , "required"]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group required">
                <label for="PostSlug">Slug :</label>
                {{ Form::text("slug" , isset($post->slug) ? $post->slug : Input::old("slug") , ["class" => "form-control" , "maxlength" => "255" , "required"]) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="PostCategoryId">Category :</label>
                {{ Form::select("categorie" , $cats , $post->category_id , ["class" => "form-control"]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="PostUserId">Author :</label>
                <select name="data[Post][user_id]" class="form-control" id="PostUserId">
                    <option value="1">Author #1</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group required">
        <label for="PostContent">Content :</label>
        {{ Form::textarea("content" , isset($post->content) ? $post->content : Input::old("content") , ["class" => "form-control" , "cols" => "30" , "rows" => "6" , "required"]) }}
    </div>
    <div class="submit">
        <input class="btn btn-primary" type="submit" value="Edit">
    </div>
    {{ Form::close() }}


</div> <!-- /container -->
@stop
