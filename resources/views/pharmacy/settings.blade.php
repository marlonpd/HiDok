@extends('layout')

@section('content')
<div class="row">

<div class="col-sm-4 col-sm-offset-4">


  {!! Form::open(array('url'=>'/settings/update','role'=>'form','files'=>true)) !!}
    {!! csrf_field() !!}


    <div class="form-group">
    	<div class="file-preview-thumbnails"><div class="file-default-preview"><img src="{{ Auth::user()->avatar() }}" alt="Your Avatar" style="width:160px"></div></div>			
    </div>

   	<div class="form-group">
        <label class="btn btn-default file-browse-btn btn-file">
	        Browse  {!! Form::file('photo') !!}
	    </label>
    </div>


    <div class="form-group">
      <label for="exampleInputEmail1">Name</label>
      <input type="text" class="form-control"  placeholder="Name" name="name" id="name" value="{{ Auth::user()->name }}" required>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">Address</label>
      <input type="text" class="form-control" placeholder="Address" name="address" id="address" value="{{ Auth::user()->address }}" required>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">Contact</label>
      <input type="text" class="form-control" placeholder="Contact no." name="contact_no" id="contact_no" value="{{ Auth::user()->contact_no }}" required>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">E-mail address</label>
      <input type="email" class="form-control"   placeholder="E-mail" name="email" value="{{ Auth::user()->email }}" required>
    </div>

    <div class="form-group">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
    </div>

    {!! Form::close() !!}

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

  
</div>
</div>

@stop