@extends('layout')

@section('content')
<div class="container">
    <div class="content-header">Appointment</div>
     <div class="row" v-for="appointment in appointments">
        <div class="col-sm-2">
            <div class="thumbnail">
                <img class="img-responsive user-photo" v-bind:src="appointment.doctor.thumbnail">
            </div><!-- /thumbnail -->
        </div><!-- /col-sm-1 -->

        <div class="col-sm-6">
            <div class="panel panel-default">
            <div class="panel-heading">
                <strong> @{{ appointment.doctor.lastname }} , @{{ appointment.doctor.firstname  }}</strong> 
                <span class="text-muted">You requested this 5 days ago</span>
            </div>
            <div class="panel-body">
                @{{ appointment.appointment_date }}
            </div><!-- /panel-body -->
            <div class="panel-footer">
                Doctor's note : @{{ appointment.note }}
            </div><!-- /panel panel-footer -->

            </div><!-- /panel panel-default -->
        </div><!-- /col-sm-5 -->

        <div class="col-sm-4">
                <div class="btn-group vcenter">
                
                <button  v-if="appointment.confirmed == 0 && appointment.re_schedule_by_id != authUser.id" type="button" class="btn btn-primary btn-success" @click="confirmAppointment(appointment, $event)">Confirm</button>


                <button  v-if="appointment.confirmed == 0 && appointment.re_schedule_by_id == authUser.id" type="button" class="btn btn-primary btn-success disabled" @click="confirmAppointment(appointment, $event)">Confirm</button>

                <button  v-if="appointment.confirmed == 1" type="button" class="btn btn-primary btn-success disabled" >Confirmed</button>                          

                <button type="button" class="btn btn-primary btn-infor" @click="reschedAppointment(appointment, $event)" data-title="Patient re-Schedule" data-toggle="modal" data-target="#patient-reschedule">Re-Schedule</button>
                <button type="button" class="btn btn-primary btn-danger" @click="deleteAppointment(appointment, $event)">Delete</button>
            </div>     
        </div><!-- /col-sm-1 -->

        <!-- /col-sm-5 -->
    </div>   

</div>

<patient-re-schedule :appointment="editAppointment" ></patient-re-schedule>
@endsection




@section('javascripts')
    <script>
        var childMixin = {

            mounted() {},

            created: function() {
                this.fetchAllAppointments();
            },

            data(){
                return {
                    appointments : {},
                    appointment : {},
                    editAppointment : {},
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
      
            },



        };
    </script>
@endsection