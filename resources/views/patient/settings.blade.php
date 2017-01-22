@extends('layout')

@section('content')
<div class="row">

<div class="col-sm-4 col-sm-offset-4">
  <form method="post" action="{{ url('/settings/profile') }}">
    {!! csrf_field() !!}

    <div class="form-group">
    	<div class="file-preview-thumbnails"><div class="file-default-preview"><img src="/images/default_avatar_male.jpg" alt="Your Avatar" style="width:160px"></div></div>			
    </div>

   	<div class="form-group">
        <label class="btn btn-default file-browse-btn btn-file">
	        Browse <input type="file" style="display: none;" name="photo" id="photo">
	    </label>
    </div>


    <div class="form-group">
      <label for="exampleInputEmail1">Name</label>
      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Name" name="name" id="name" value="{{ Auth::user()->name }}" required>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">E-mail address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" placeholder="E-mail" name="email" value="{{ Auth::user()->email }}" required>
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">Old password</label>
      <input type="password" class="form-control" id="old_password" placeholder="Password" name="old_password">
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" id="password" placeholder="Password" name="password">
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" id="password_confirmation" placeholder="Password" name="password_confirmation">
    </div>


    <div class="form-group">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
    </div>


    @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

  </form>
</div>
</div>

@stop