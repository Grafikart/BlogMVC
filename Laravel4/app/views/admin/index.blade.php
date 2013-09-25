@extends('layouts.blog')

@section('title')
Admin
@stop

@section('content')
	<h1>Manage posts</h1>

	<p>{{ HTML::linkRoute('admin.create', 'Add a new post', array(), array('class' => 'btn btn-primary')) }}</p>

	<table class="table table-striped">
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
					<td>{{ e($post->name) }}</td>
					<td>{{ e($post->category->name) }}</td>
					<td>{{ date("d/m/Y H:i", $post->created_at->timestamp) }}</td>
					<td>
						{{ HTML::linkRoute('admin.edit', 'Edit', array($post->slug), array('class' => 'btn btn-primary')) }}
						{{ HTML::linkRoute('admin.delete', 'Delete', array($post->slug), array('class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Are you sure ?\')')) }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	{{ $posts->links() }}
@stop