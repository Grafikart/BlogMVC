@section('title', 'Login')

{{ Form::open(["action" => "UsersController@doLogin" , "class" => "form-signin"]) }}

    <h4 class="form-signin-heading">Please sign in</h4>

    @if ( Session::has("error") )
        <div class="alert alert-danger">
            <strong>Oops, Something Wrong</strong> <br/>
            {{ Session::get("error") }}
        </div>
    @endif


    {{ Form::text("username" , "", ["class"=>"form-control", "placeholder"=>"Username", "autofocus"]) }}
    {{ Form::password("password", ["class"=>"form-control", "placeholder"=>"Password"]) }}
    {{ Form::submit("Sign in", ["class"=>"btn btn-lg btn-primary btn-block"]) }}

{{ Form::close() }}

