@extends('layouts.master')

@section('content')
<div class="container">

    <br/>
    <p><a href="{{ URL::route('admin.index') }}">< Back to posts</a></p>

    {{ Form::open(["route" => "admin.posts.store" , "id" => "PostAdminEditForm"]) }}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group required">
                <label for="PostName">Name :</label>
                <input name="name" value="{{ Input::old('name') }}" class="form-control" maxlength="255" type="text" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group required">
                <label for="PostSlug">Slug :</label>
                <input name="slug" value="{{ Input::old('slug') }}" class="form-control" maxlength="255" type="text" required="required">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="PostCategoryId">Category :</label>
                <select name="categorie" class="form-control" id="PostCategoryId" required>
                    <option value="">--------------</option>
                    @foreach ($categories as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="PostUserId">Author :</label>
                <select name="author" class="form-control" id="PostUserId">
                    <option value="1">Author #1</option>
                </select>
            </div>
        </div>
    </div>

    @if ( $errors->has('content') )
    <div class="form-group required has-error">
            <label for="PostContent">Content :</label>
            <textarea name="content" class="form-control" cols="30" rows="6" id="PostContent" required="required">{{ Input::old('content') }}</textarea>
    <strong>{{ $errors->first('content') }}</strong>
    @else
    <div class="form-group required">
        <label for="PostContent">Content :</label>
        <textarea name="content" class="form-control" cols="30" rows="6" id="PostContent" required="required">{{ Input::old('content') }}</textarea>
    </div>
    @endif
    <div class="submit">
        <input class="btn btn-primary" type="submit" value="Submit">
    </div>
    {{ Form::close() }}


</div> <!-- /container -->

@stop
