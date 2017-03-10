@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="search-pnl col-md-12"> 
            <form action="/search" method="get"> 
                <input type="hidden" name="account" value="doctor">
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="specialization" name="specialization" placeholder="Specialization" value="{{ $specialization}}">
                  </div>

                   <div class="col-md-4">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $name}}">
                  </div>

                   <div class="col-md-2">
                    <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{$location}}">
                  </div>
                   <div class="col-md-2"> <button type="submit" class="btn default-btn">Submit</button></div> 
            </form>
        </div>

        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Search results...</div>

                <div class="search panel-body">
                    

                    @foreach ($doctors as $doctor)
                        <div class="col-md-12  col-md-offset-0 search-items-pnl">
                            <div class="pull-left col-md-3 photo-container">
                              <img src="{{$doctor->thumbnail}}" width="100%" >
                            </div>

                            <div class="pull-right col-md-8">
                                <div class="col-md-8 pull-left basic-info-pnl">
                                    <span>Dr. {{$doctor->lastname}}, {{$doctor->firstname}}  {{$doctor->middlename}}</span>
                                    <br>{{$doctor->specialization}}
                                    <br><br>
                                    <p>{{$doctor->address}}  <br>
                                       Tel. no. : {{$doctor->contact_no}} <br>
                                       Email address : {{$doctor->email}}
                                    </p>

                                </div>

                                <div class="col-md-4 pull-right profile-rate-sched-pnl">
                                    <a class="default-btn" href="/doctor/profile/{{$doctor->id}}">View Profile</a>
                                </div>
                                
                            </div>
                        </div>
                     @endforeach


     

               
                   
                </div>
   
            </div>
        </div>


    </div>
</div>
@endsection





@section('javascripts')
    <script>
        var childMixin = {

            mounted(){
              
            },
            created: function() {
               
            },

            mounted(){
              
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