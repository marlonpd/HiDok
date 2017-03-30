

        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                 <div class="panel-body">

                    <div id="accordion">
                      
                       @foreach ($clinics as $clinic)
                          <h3>{{ $clinic->name }}, {{ $clinic->address }}, {{ $clinic->from_day }}-{{ $clinic->to_day }} @ {{ $clinic->from_time }} - {{ $clinic->to_time }}</h3>
                          <div>
                            <p>

                                 <div class="row" v-for="appointment in appointments['{!! $clinic->id !!}']">
                                        <div class="col-sm-2">
                                            <div class="thumbnail">
                                                <img class="img-responsive user-photo"  :src="appointment.patient.thumbnail">
                                            </div><!-- /thumbnail -->
                                        </div><!-- /col-sm-1 -->

                                        <div class="col-sm-4">
                                            <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <strong> @{{ appointment.patient.lastname }} , @{{ appointment.patient.firstname  }}</strong> 
                                                <span class="text-muted">requested 5 days ago</span>
                                            </div>
                                            <div class="panel-body">
                                             @{{ appointment.appointment_date }}
                                             <br>
                                             Note: @{{ appointment.note }}
                                             
                                            </div><!-- /panel-body -->
                                            </div><!-- /panel panel-default -->
                                        </div><!-- /col-sm-5 -->

                                        <div class="col-sm-6">
                                             <div class="btn-group vcenter">
                                                <button  v-if="appointment.confirmed == 0 && appointment.re_schedule_by_id != authUser.id" type="button" class="btn btn-primary btn-success" @click="confirmAppointment(appointment, $event)"> Confirm</button>
                                                <button  v-if="appointment.confirmed == 0 && appointment.re_schedule_by_id == authUser.id" type="button" class="btn btn-primary btn-success disabled" @click="confirmAppointment(appointment, $event)">Confirm</button>                                                                 
                                                <button  v-if="appointment.confirmed == 1 && appointment.re_schedule_by_id != authUser.id" type="button" class="btn btn-primary btn-success" @click="consult(appointment)">Consult</button>
                                                <button  v-if="appointment.confirmed == 1 && appointment.re_schedule_by_id == authUser.id" type="button" class="btn btn-primary btn-success disabled" @click="consult(appointment)">Consult</button>
                                                <button  v-if="appointment.confirmed == 2" type="button" class="btn btn-primary btn-success disabled" >Consult</button>
                                                <button type="button" class="btn btn-primary btn-infor" @click="viewITR(appointment)">ITR</button>                                             
                                                <button type="button" class="btn btn-primary btn-infor"  data-title="Re-Schedule" data-toggle="modal" data-target="#reschedule" @click="setAppointmentChild(appointment)">Re-Schedule</button>
                                                <button type="button" class="btn btn-primary btn-danger" @click="deleteAppointment(appointment, $event)">Delete</button>
                                            </div>
                                        </div><!-- /col-sm-1 -->

                                        <!-- /col-sm-5 -->
                                    </div> 



                            </p>
                          </div>
                       @endforeach
                     
                    </div>
                </div>



                
            </div>
        </div>


<re-schedule :appointment="editAppointment" ></re-schedule>



<script>
    var childMixin = {

        mounted() {
        },

        created: function() {
            this.fetchAllAppointments();//appointments tab
            this.fetchPatientITR(0); 
        },

        data(){
            return {
                appointments : {},
                appointment : {},
                editAppointment : {},

                schedule : {},   
                appoinment_id : 0,
                editAppointment : {},
            }
        },

        events: {},

        methods: {

            fetchPatientITR : function(id){
                this.$http.get('/api/patient/itr/get/'+id, function(data){
                this.appointmentITR = data['appointment_itr'];
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
                }).then(function (isConfirm,appointment) {

                    if(isConfirm){   
                        self.$http.post('/api/appointment/delete/post', thisAppointment.id, function(data){
                        if(data == "success"){
                            swal('Deleted!','Your item has been deleted.', 'success' );
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