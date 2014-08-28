@section('title', 'Manage posts')

<h1>Manage posts</h1>

<p><a href="{{ URL::route('admin.posts.create') }}" class="btn btn-primary">Create a new post</a></p>

<table class="table table-striped table-flip-scroll cf">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Publication date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->name }}</td>
                <td>{{ $post->category->name }}</td>
                <td>{{ $post->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ URL::route('admin.posts.edit', $post->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Editer</a>
                    <a href="{{ URL::route('admin.posts.destroy', $post->id) }}" class="btn btn-danger" data-method="delete"><i class="fa fa-trash-o"></i> Supprimer</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
