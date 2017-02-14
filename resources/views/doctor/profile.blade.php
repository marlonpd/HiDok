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
                            <a type="button" class="btn btn-sm" href="#" data-title="Feedback" data-toggle="modal" data-target="#feedback"><i class="fa fa-comments"></i></a>

                            <a data-title="Create Appointment" data-toggle="modal" data-target="#create-appointment" type="button" class="btn btn-sm btn-danger"><i class="fa fa-address-book-o"></i></a>
                            
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

<create-appointment :schedules="schedules" :doctor_id="{!! $user->id !!}"></create-appointment>


<!-- feedback modal -->
<div class="modal" id="feedback" tabindex="-1" role="dialog" aria-labelledby="feedback" aria-hidden="true">
  <div class="modal-dialog">
        
         <div class="col-md-12">
                  <div class="widget-area no-padding blank">
                    <div class="status-upload">
                      <form>
                        <textarea v-model="newFeedback.content" placeholder="Add some feedback?" ></textarea>
                        
                        <button @click="submitFeedback($event)" type="submit" class="btn btn-success green"><i class="fa fa-share"></i> Submit</button>
                      </form>
                    </div><!-- Status Upload  -->
                  </div><!-- Widget Area -->
                </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
</div>

<!-- end of feedback modal -->

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
              this.fetchSchedules('{!! $user->id !!}');
            },

            mounted(){
              
            },

            data: function(){
                return {
                        newFeedback :{
                            id : null,
                            doctor_id : '{!! $user->id !!}',
                            content: null,
                        }
                }
            },

            methods:{
                submitFeedback: function(event){
                    event.preventDefault();

                    swal({
                      text: 'Submitting....',
                      timer: 1000,
                      showConfirmButton : false,
                      type : 'info',
                    }).then(
                      function () {},
                      function (dismiss) {
                      }
                    )

                    self = this;
                    this.$http.post('/api/feedback/post', this.newFeedback,function(data){
                        if(data == "success"){
                            swal({
                              title: 'Success!',
                              text: 'Successfully sent your feedback.',
                              showConfirmButton : false,
                              timer: 1000,
                              type : 'success',
                            }).then(
                              function () {},
                              function (dismiss) {
                                if (dismiss === 'timer') {
                                  console.log('I was closed by the timer');
                                  self.newFeedback.content = '';
                                  $('#feedback').modal('hide');

                                }
                              }
                            );
                        }else{


                             swal({
                                title: 'Error!',
                                text: 'Unable to submit ur feedback, please try again!',
                                timer: 1000,
                                type : 'error',
                                showConfirmButton : false,
                              }).then(
                                function () {},
                                function (dismiss) {
                                  if (dismiss === 'timer') {
                                    console.log('I was closed by the timer')
                                  }
                                }
                              )

                        }
                    });

                }


            }
          };

      </script>
@endsection