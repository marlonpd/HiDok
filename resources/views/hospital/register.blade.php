@extends('layout')

@section('content')
   <div class="row">
    <div class="col-sm-4 col-sm-offset-4">
      <h2>Please sign up | {{Config::get('constants.account_type_label.hospital') }}</h2>

      <form method="post" action="{{ url('/hospital/register') }}">
        {!! csrf_field() !!}

        <input type="hidden" name="account_type" id="account_type" value="{{ Config::get('constants.account_type.hospital') }}">

        <div class="form-group">
          <label for="exampleInputEmail1">Name</label>
          <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Name" name="name" id="name" value="{{ old('name') }}" required>
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