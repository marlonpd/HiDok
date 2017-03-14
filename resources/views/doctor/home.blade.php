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
              @include('doctor.partials.appointment')
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
                // this.fetchPatientITR(0); 
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

                setAppointmentMain : function(appointment){
                    this.editAppointment = appointment;
                    Vue.nextTick(function () {});
                },

                viewITR : function(appointment){
                    window.location = "/patient/itr/"+appointment.patient_id;
                },

                setAppointmentChild: function(appointment){
                    this.$data.editAppointment = appointment;
                },

                fetchScheduleAppointment : function(clinic_id){
                    this.$http.get('/api/auth/appointment/get/'+clinic_id, function(data){
                        this.appointments = data['appointments'];
                    });
                },

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

                consult : function(appointment){
                    this.$http.post('/api/appointment/consult/post', appointment, function(data){
                        if(data == 'success'){
                        appointment.confirmed = 2;
                        }else{
                        swal("Error","Please try again!", "error");
                        }
                    });
                },

                reschedAppointment : function(appointment, event){
                    event.preventDefault();
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
                    }).then(function (isConfirm,appointment) {
                            if(isConfirm){       
                                self.$http.post('/api/appointment/delete/post', thisAppointment.id, function(data){
                                    if(data == "success"){
                                        swal(
                                            'Deleted!',
                                            'Your item has been deleted.',
                                            'success'
                                        );

                                        this.fetchScheduleAppointment(self.clinic_id);
                                    }
                                });
                    

                            }
                            else
                            {
                                swal("cancelled","Your categories are safe", "error");
                            }
                    });

                    
                },
      
            },



        };
    </script>
@endsection

