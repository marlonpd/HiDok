@extends('layout')

@section('content')
<div class="container">
    
    <div class="panel panel-default">
    <div class="panel-heading">Appointment</div>
    <div class="panel-body">


                            <div class="shadow"  v-for="appointment in appointments" >
                            <div class="row">
                                <div class="col-sm-1">
                                    <img :src="'/'+appointment.doctor.thumbnail" width="60px">
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <strong> @{{ appointment.doctor.lastname }} , @{{ appointment.doctor.firstname  }}</strong> 
                                            <span class="text-muted">You requested this 5 days ago</span>
                                        </div>
                                        <div class="panel-body">
                                            @{{ appointment.appointment_date }}
                                            <br>
                                            Doctor's note : @{{ appointment.note }}

                                        </div><!-- /panel-body -->
                                    </div><!-- /panel panel-default -->
                                </div><!-- /col-sm-6 -->
                                
                                <div class="col-sm-5">
                                        <button  v-if="appointment.confirmed == 0 && appointment.re_schedule_by_id != authUser.id" type="button" class="btn btn-primary btn-success" @click="confirmAppointment(appointment, $event)">Confirm</button>
                                        <button  v-if="appointment.confirmed == 0 && appointment.re_schedule_by_id == authUser.id" type="button" class="btn btn-primary btn-success disabled" @click="confirmAppointment(appointment, $event)">Confirm</button>
                                        <button  v-if="appointment.confirmed == 1" type="button" class="btn btn-primary btn-success disabled" >Confirmed</button>                          
                                        <button type="button" class="btn btn-primary btn-infor" @click="reschedAppointment(appointment, $event)" data-title="Patient re-Schedule" data-toggle="modal" data-target="#patient-reschedule">Re-Schedule</button>
                                        <button type="button" class="btn btn-primary btn-danger" @click="deleteAppointment(appointment, $event)">Delete</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr />
                            <div class="clearfix"></div>
                        </div>

    


</div>
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
                    lastdate : "",
                    showLoadMoreBtn : true, 
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


                fetchAppointments: function(){
                    this.$http.get('/api/appointments/get?lastdate='+this.lastdate, function(data){
                        this.appointments = data['appointments'];
                    });
                },
                
                loadMore: function(){
                    var lastitem = this.appointments[Object.keys(this.appointments)[Object.keys(this.appointments).length - 1]];
                    this.lastdate = lastitem.created_at;
                    self = this;
                    var l = Ladda.create(document.querySelector( '.loader' ));
                    l.start();
                    this.$http.get('/api/appointments/get?lastdate='+this.lastdate, function(data){
                        var apps = data['appointments'];
                        if(data['remaining'] == 0){
                            self.showLoadMoreBtn = false;
                        }

                        if(data['error'] == 'Unauthenticated'){
                            windows.location = 'http://hidok.com';
                        }

                        apps.forEach(function(app , index){
                            self.consultations.push(app);
                        });
                        l.stop();
                    });
                }
      
            },



        };
    </script>
@endsection