@extends('layout')

@section('content')
	 <div class="row">
    <div class="col-sm-4 col-sm-offset-4">
      <h2>Please sign up | Doctor</h2>

      <form method="post" action="{{ url('/register') }}">
        {!! csrf_field() !!}

        <div class="form-group">
          <label for="exampleInputEmail1">Lastname</label>
          <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Lastname" name="lastname" id="lastname" value="{{ old('lastname') }}" required>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Firstname</label>
          <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Firstname" name="firstname" id="firstname" value="{{ old('firstname') }}" required>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Middle name</label>
          <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Middle name" name="middlename" id="middlename" value="{{ old('middlename') }}" required>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">E-mail address</label>
          <input type="email" class="form-control" id="email" placeholder="E-mail" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="password_confirmation" placeholder="Password" name="password_confirmation" required>
        </div>


        <div class="form-group">
          <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
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