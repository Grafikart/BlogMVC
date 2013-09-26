@extends('layouts.master')

@section('content')

<div class="container">

    <h1>Manage posts</h1>

    {{ HTML::linkRoute("admin.posts.create" , "Add new Post" , [] , ["class" => "btn btn-primary"]) }}

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Publication date</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        @foreach ( $posts as $post )
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->name }}</td>
                <td>{{ $post->created }}</td>
                <td>{{ $post->categorie['name'] }}</td>
                <td>
                    <a href="{{ URL::route('admin.posts.edit' , $post->id) }}" class="btn btn-primary">Edit</a>
                    <a href="admin/posts/{{ $post->id }}/destroy" class="btn btn-danger" onclick="return confirm('Are you sure ?')">Delete</a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

        {{ $posts->links() }}

</div> <!-- /container -->

@stop
