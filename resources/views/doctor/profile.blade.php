@extends('layout')

@section('content')
<div class="container">
      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">{{$user->lastname}}, {{$user->firstname}}  {{$user->middlename}}</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="/{{$user->thumbnail}}" class="img-circle img-responsive"> </div>09
                
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Specialization:</td>
                        <td>{{ $user->specialization}}</td>
                      </tr>
                    
                         <tr>
                             <tr>
                                <td>Gender</td>
                                <td>{{ $user->gender}}</td>
                              </tr>
                            <tr>
                              <td>Home Address</td>
                              <td>{{ $user->address}}</td>
                            </tr>
                        <tr>
                        <td>Email</td>
                        <td><a href="mailto:info@support.com">{{ $user->email}}</a></td>
                      </tr>
                        <td>Phone Number</td>
                        <td>{{ $user->contact_no}}
                        </td>
                      </tr>
                      <tr>
                        <td>Rate</td> 
                        <td>
                        <div class="rating">
                            <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                        </div>
                        </td>
                      </tr>
                     
                    </tbody>
                  </table>
                
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                        <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                        <span class="pull-right">
                            <a href="#" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="fa fa-star" aria-hidden="true"></i>
</a>
                            <a type="button" class="btn btn-sm" href="#" data-title="Feedback" data-toggle="modal" data-target="#create-feedback-form"><i class="fa fa-comments"></i></a>

                             <a type="button" class="btn btn-sm btn-danger" href="#" data-title="Request Appointment" data-toggle="modal" data-target="#create-appointment-form"><i class="fa fa-address-book-o"></i></a>


                            
                        </span>
                    </div>
            
          </div>
        </div>
      </div>

<!-- Feedback -->
 <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
            <div class="panel-heading">
              <h3 class="panel-title">Feedback</h3>
            </div>
            <div class="panel panel-primary">
                <div class="panel-body">
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
    </div>

<!-- end of feedback -->



</div>

<create-appointment-form :clinics="clinics" :doctor_id="{!! $user->id !!}"></create-appointment-form>

<create-feedback-form :doctor_id="{!! $user->id !!}"></create-feedback-form>


@endsection


@section('javascripts')
      <script type="text/javascript">
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