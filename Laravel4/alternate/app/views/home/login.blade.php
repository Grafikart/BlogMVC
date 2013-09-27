@extends('layouts.master')

@section('content')

<div class="container">

    {{ Form::open(["url" => "users/login" , "class" => "form-signin"]) }}
    <h4 class="form-signin-heading">Please sign in</h4>
    @if ( Session::has("alert_error") )
          <div class="alert alert-danger">
              <strong>Oops, Something Wrong</strong> <br/>
              {{ Session::get("alert_error") }}
          </div>
    @endif
    {{ Form::text("username" , "", ["class"=>"form-control", "placeholder"=>"Username", "autofocus"]) }}
    {{ Form::password("password", ["class"=>"form-control", "placeholder"=>"Password"]) }}
    {{ Form::submit("Sign in", ["class"=>"btn btn-lg btn-primary btn-block"]) }}
    {{ Form::close() }}

</div> <!-- /container -->

@stop
