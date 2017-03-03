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
      <label for="exampleInputEmail1">Last name</label>
      <input type="text" class="form-control"  placeholder="lastname" name="lastname" id="lastname" value="{{ Auth::user()->lastname }}" required>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">First name</label>
      <input type="text" class="form-control"   placeholder="Firstname" name="firstname" id="firstname" value="{{ Auth::user()->firstname }}" required>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">Middle name</label>
      <input type="text" class="form-control"   placeholder="Middlename" name="middlename" id="middlename" value="{{ Auth::user()->middlename }}" required>
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
      <label for="exampleInputEmail1">Specialization</label>
    
      <select name="specialization" id="specialization" v-model="authUser.specialization"  class="form-control">
          <option disabled>Select...</option>
          <template v-for="specialization in constants['specialization']">
            <option  v-bind:value="specialization" >@{{ specialization }}</option>
          </template>
      </select>

    </div>


    <div class="form-group">  
      <label for="exampleInputEmail1">Gender</label>
     

      <select name="gender" id="gender" v-model="authUser.gender"  class="form-control">
          <option disabled>Select...</option>
          <template v-for="gender in constants['gender']">
            <option  v-bind:value="gender" >@{{ gender }}</option>
          </template>
      </select>

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





@section('javascripts')
    <script>

        var childMixin = {

            mounted(){
                    
            },
            created: function() {    

              

            },



            data: function(){
                return {
                   
                }
            },

            methods:{
                
            }

        };
    </script>
@endsection
