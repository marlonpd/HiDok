@extends('layout')

@section('content')
<div class="container">
  
    <div id="exTab2" class="col-md-12 col-md-offset-0 home-tabs"> 
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
              <doctor-profile-form :constants="constants" :authUser="authUser"></doctor-profile-form>
          </div>
          <div class="tab-pane" id="2">
              appointment
          </div>
          <div class="tab-pane" id="3">
            history
          </div>
        </div>
  </div>




</div>
@endsection





@section('javascripts')
    <script>

        $( function() {
            $( "#accordion" ).accordion();
        });

        var childMixin = {

            mounted() {
            },

            created: function() {
                this.fetchAllAppointments();
                 this.fetchPatientITR(0); 
            },

            data(){
                return {
                    appointments : {},
                    appointment : {},
                    editAppointment : {},
                    appointmentITR : {}
                }
            },

            events: {

            },

            methods: {

                confirmAppointment : function(appointment, event){
                    event.preventDefault();
                    this.$http.post('/api/appointment/confirm/post', appointment, function(data){
                        if(data == 'success'){
                          appointment.confirmed = 1;
                        }else{
                          swal("Error","Please try again!", "error");
                        }
                    });
                },

                reschedAppointment : function(appointment, event){
                    event.preventDefault();
                    this.editAppointment = appointment;
                },

                deleteAppointment : function(appointment, event){
                    event.preventDefault();
                    var self = this; 
                    var thisAppointment = appointment;

                    swal({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }
                    ).then(function (isConfirm,appointment) {

                      if(isConfirm){
                
                        self.$http.post('/api/appointment/delete/post', thisAppointment.id, function(data){
                          if(data == "success"){
                            swal(
                              'Deleted!',
                              'Your item has been deleted.',
                              'success'
                            );

                            this.fetchScheduleAppointment(thisAppointment.id);
                          }
                        });
             

                      }
                      else
                      {
                          swal("cancelled","Your categories are safe", "error");
                      }

                      
                    });

                    
                },

                fetchConsultedAppointment: function(){
                    this.$http.get('/api/appointment/consult/get', function(data){
                        this.appointments = data['appointments'];
                    });
                },


                fetchPatientITR : function(id){
                  this.$http.get('/api/patient/itr/get/'+id, function(data){
                    this.appointmentITR = data['appointment_itr'];
                  });
                },
      
            },



        };
    </script>
@endsection

