@extends('layout')

@section('content')
<div class="container">
      <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
              <div class="col-md-3 pull-left">
                
                <div class="row" align="center"> 
                  <img alt="User Pic" src="{{$user->thumbnail}}" class="img-circle img-responsive"> 
                </div>
                 <span  class="row"> <h4 class="name-title">{{ $user->fullname() }} </h4>
                  <span > {{$user->specialization}}</span>
                 </span>
                 

                 <span  class="row">
                    <div class="Fr-star userChoose size-1" data-title="{{ round($doctor_rate['rate_value'], 2) }} / 5 by {{ $doctor_rate['rate_times'] }} ratings" data-rating=" {{ $doctor_rate['rate_value'] }}">
                      <div class="Fr-star-value" style="width: {{$doctor_rate['rate_bg']}}%"></div>
                      <div class="Fr-star-bg"></div>';

                    </div>
                    <br>
                    <span>Your rating :  <div id="current-user-rate">{{ $doctor_rate['current_user_rating'] }}</div> </span>
                 </span>
                 <span class="row">
                    <a type="button" class="btn default-btn btn-block" href="#" data-title="Request Appointment" data-toggle="modal" data-target="#create-appointment-form">Request an Appointment</a>
                 </span>

                 <span class="row">
                   <a type="button" class="btn default-btn btn-block " href="#" data-title="Feedback" data-toggle="modal" data-target="#create-feedback-form">Write a feedback</a>
                 </span>
                 
                 <span class="row">
                   <a type="button" class="btn default-btn btn-block " href="#" data-title="Feedback" data-toggle="modal" data-target="#ask-connect-form" @click="askConnect();">Connect+</a>
                 </span>

                 <div class="row">
                   <h2 class="header-title">Feedback</h2>
                   <div>
                      <ul class="chat">
                        <li class="left clearfix" v-for="feedback in feedbacks"><span class="chat-img pull-left" >
                            <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">@{{ feedback.patient.lastname }} , @{{ feedback.patient.firstname  }}</strong> <small class="pull-right text-muted">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i> @{{ feedback.created_at }}</small>
                                </div>
                                <p>
                                     @{{ feedback.content }}
                                </p>
                            </div>
                        </li>  
                    </ul> 



                   </div>
                 </div>


                
              </div>

              <div class="col-md-9 pull-left">
                  <div class="row gmap-clinic-pnl">
                      <div class="clinic-pnl col-md-4 pull-left">
                         <h4 class='header-title'> {{ $user['clinic']->name }}</h4>
                         <p><span>Schedule</span> : {{ $user['clinic']->available_day() }}</p>
                         <p> <span>Time : </span> {{ $user['clinic']->from_time }} - {{ $user['clinic']->to_time }} </p>
                         <p> <span>Address : </span>{{ $user['clinic']->address }}</p>
                         <p> <span>Contact no : </span> {{ $user->contact_no }}</p>
                         <p><span> Email : </span> {{ $user->email }}</p>
                                            
                      </div>

                      <div class="gmap-pnl col-md-8 pull-right">
                           <div class="gmap-container">
                              <div id="map_canvas" style="width:100%;height: 100%;"></div>
                           </div>
                      </div>
                  </div>

                  <div class="additional-detail-pnl row">
                    <h4>Qualifications and Experience</h4>

                    <div class="form-horizontal">
                      <div class="form-group">
                          <label class="col-sm-3" for="inputEmail1">Email</label>
                           <div class="col-sm-9"> email@yahoo.com</div>
                      </div>
                    
                       <div class="form-group">
                       <label class="col-sm-3" for="inputEmail1">Email</label>
                           <div class="col-sm-9"> email@yahoo.com</div>
                      </div>

                      <div class="form-group">
                       <label class="col-sm-3" for="inputEmail1">Email</label>
                           <div class="col-sm-9"> email@yahoo.com</div>
                      </div>

                    </div>


                    
                  </div>
              </div>

            </div>
       </div>
</div>

<create-appointment-form :clinics="clinics" :doctor_id="'{{ $user->id }}'"></create-appointment-form>

<create-feedback-form :doctor_id="'{{ $user->id }}'"></create-feedback-form>

@endsection


@section('javascripts')
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyANvZAZmHJVMI8lGIyCU4v-aduI1bhVIsg&sensor=false"></script>
<script type="text/javascript">
          $(function(){
            $(".Fr-star.userChoose").Fr_star(function(rating){

              swal({
                title: 'Rating!',
                text: 'You rate '+rating,
                showConfirmButton : false,
                timer: 1000,
                type : 'info',
              }).then(function () {},function (dismiss) {});
              
              $.post("/api/rate/post", {'doctor_id' :'{!! $user->id !!}', 'rating': rating}, function(){                 
                $("#current-user-rate").html(rating);
              });
            });
          });


          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });  
          
          var childMixin = {

            created: function() {
              this.fetchApprovedFeedback('{!! $user->id !!}');
              this.fetchClinics('{!! $user->id !!}');
            },

            mounted(){
              var myOptions = {center: new google.maps.LatLng('{!! $user["clinic"]->gmap_lat !!}','{!! $user["clinic"]->gmap_lng !!}'),
                               zoom: 18,
                               mapTypeId: google.maps.MapTypeId.ROADMAP
              };

              var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
              
              var lat = '{!! $user["clinic"]->gmap_lat !!}';		
              var lng = '{!! $user["clinic"]->gmap_lng !!}';

              marker = new google.maps.Marker({
                  position: new google.maps.LatLng(lat, lng),
                  map: map
              });

              
            },

            data: function(){
                return {
       
                }
            },

            methods:{
                askConnect: function(){
                  swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then(function () {
                    swal(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                  })
                },

                requestConnect: function(){
                    var data = {doctor_id : '{!! $user->id !!}' }
                    this.$http.post('/api/request/connect/post', data, function(data){
                      if(data['status'] == 'success'){
                        
                      }else{
                        swal("Error","Please try again!", "error");
                      }
                    });
                }
                

            }
          };

      </script>
@endsection