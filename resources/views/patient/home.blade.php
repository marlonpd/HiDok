@extends('layout')

@section('content')
<div class="container">
    


    <div id="exTab2" class="col-md-8 col-md-offset-2 home-tabs"> 
<ul class="nav nav-tabs">
      <li class="active">
        <a href="#1" data-toggle="tab">PROFILE</a>
      </li>
      <li class=""><a href="#2" data-toggle="tab">APPOINTMENTS</a>
      </li>
      <li class=""><a href="#3" data-toggle="tab">MY HEALTH HISTORY</a>
      </li>
    </ul>

      <div class="tab-content ">
        <div class="tab-pane active" id="1">  
            @include('patient.partials.profile')
        </div>
        <div class="tab-pane" id="2">
             @include('patient.partials.appointment')
        </div>
        <div class="tab-pane" id="3">
           @include('patient.partials.itr')
        </div>
      </div>
  </div>

















</div>
@endsection



