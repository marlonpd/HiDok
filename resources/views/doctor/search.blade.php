@extends('layout')

@section('content')
<div class="container">
    <div class="panel panel-default">
            <div class="panel-heading">
                <div class="search-pnl"> 
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
                        <div class="col-md-2"> <button type="submit" class="btn default-btn">Search</button></div> 
                    </form>
                </div>
                <div class="clr"></div>
            </div>
            <div class="panel-body">
                @foreach ($doctors as $doctor)    
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body padding-lr-0">
                                <div class="row">
                                    

                                        <div class="col-md-4  padding-lr-0">
                                            <div class="thumbnail">    
                                            <img  src="/{{$doctor->thumbnail}}" class="img-responsive user-photo thumb">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6><a href="/doctor/profile/{{$doctor->id}}"> Dr. {{$doctor->lastname}}, {{$doctor->firstname}}  {{$doctor->middlename}}</a></h6>
                                            <p>{{$doctor->specialization}}</p>
                                            <p>{{$doctor->address}}  <br>
                                                No. : {{$doctor->contact_no}} <br>
                                                {{$doctor->email}}
                                            </p>
                                            
                                        </div>

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


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