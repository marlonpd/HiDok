@extends('layout')

@section('content')
<div class="container">
      <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
              <div class="col-md-3 pull-left">
                
                <div class="row" align="center"> 
                  <img alt="User Pic" src="{{$user->thumbnail}}" class="img-circle img-responsive"> 
                </div>

                 <span  class="row"> {{ $user->fullname() }} </span>

                 <span  class="row">
                   <span  >☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                 </span>
                 <span class="row">
                    <a type="button" class="btn default-btn" href="#" data-title="Request Appointment" data-toggle="modal" data-target="#create-appointment-form">Request an Appointment</a>
                 </span>

                 <span class="row">
                   <a type="button" class="btn default-btn" href="#" data-title="Feedback" data-toggle="modal" data-target="#create-feedback-form">Write a feedback</a>
                 </span>


                
              </div>

              <div class="col-md-9 pull-left">
                  <div class="row gmap-clinic-pnl">
                      <div class="clinic-pnl col-md-6 pull-left">
                        
                      </div>

                      <div class="gmap-pnl col-md-6 pull-right">
                           <div class="gmap-container">
                             
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

<create-appointment-form :clinics="clinics" :doctorId="'{{ $user->id }}'"></create-appointment-form>

<create-feedback-form :doctorId="'{{ $user->id }}'"></create-feedback-form>

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