@section('title', ($post->id ? 'Edit' : 'Add') . ' post')

<div class="page-title">
    @if ($post->id)
        <h1>Edit a post</h1>
    @else
        <h1>Add a post</h1>
    @endif
</div>


{{ BootForm::open($post, ['controller' => 'Admin\PostsController']) }}

<div class="row">
    <div class="col-md-6 col-sm-12">
        {{ BootForm::text("name", 'Name :') }}
    </div>
    <div class="col-md-6 col-sm-12">
        {{ BootForm::text("slug", 'Slug :') }}
    </div>
    <div class="col-md-6 col-sm-12">
        {{ BootForm::select("category_id", 'Category :', Category::lists('name', 'id')) }}
    </div>
    <div class="col-md-6 col-sm-12">
        {{ BootForm::select("user_id", 'Author :', User::lists('username', 'id')) }}
    </div>
</div>
{{ BootForm::textarea("content", 'Content :') }}
{{ BootForm::submit($post->id ? 'Edit' : 'Add') }}


{{ BootForm::close() }}
