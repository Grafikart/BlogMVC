@section('title', $post->name);

<div class="row">
    <div class="col-md-8">

        <article>
            <h1>{{ $post->name }}</h1>

            <p><small>
                Category : <a href="{{ $post->category_url }}">{{ $post->category->name }}</a>,
                by <a href="index.html">{{ $post->user->username }}</a> on <em>{{ $post->created_at->format('F jS, H:i') }}</em>
            </small></p>

            {{ Markdown::render($post->content) }}

        </article>

        <hr>

        <section class="comments">

            @if(Session::has('error'))
                <div class="alert alert-danger">
                    <strong>{{ Session::get('error') }}</strong>
                </div>
            @endif

            @if(Session::has('success'))
                <div class="alert alert-success">
                    <strong>{{ Session::get('success') }}</strong>
                </div>
            @endif

            {{ Form::open(["route" => "comments.store"]) }}
                {{ Form::hidden("post_id", $post->id) }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('email') ? "has-error" : "" }}">
                            <input type="email" class="form-control" name="email" value="{{ Input::old('email') }}" placeholder="Your email">
                            {{ $errors->first('email') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('username') ? "has-error" : "" }}">
                            <input type="text" class="form-control" name="username" value="{{ Input::old('username') }}" placeholder="Your username">
                            {{ $errors->first('username') }}
                        </div>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('content') ? "has-error" : "" }}">
                    <textarea name="content" class="form-control" rows="3" placeholder="Your comment">{{ Input::old('content') }}</textarea>
                    {{ $errors->first('content') }}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            {{ Form::close() }}

            @foreach($post->comments as $comment)
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{ forxer\Gravatar\Gravatar::image($comment->mail) }}" width="100%">
                    </div>
                    <div class="col-md-10">
                        <p>
                            <strong>{{{ $comment->username }}}</strong> {{ $comment->created_at->diffForHumans() }}
                        </p>
                        <p> {{{ $comment->content }}} </p>
                    </div>
                </div>
            @endforeach

        </section>


    </div>

    @cacheinclude('elements.sidebar', 'sidebar')

</div>