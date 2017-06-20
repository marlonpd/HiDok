@extends('layout')

@section('content')
<div class="container">
    <div class="row">

            <div class="panel panel-default">
                <div class="panel-heading">Appointments</div>

                <div class="panel-body">

                  
                      



                                 <div class="row" v-for="appointment in appointments">
                                        <div class="col-sm-2">
                                            <div class="thumbnail">
                                                <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                            </div><!-- /thumbnail -->
                                        </div><!-- /col-sm-1 -->

                                        <div class="col-sm-4">
                                            <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <strong> @{{ appointment.patient.lastname }} , @{{ appointment.patient.firstname  }}</strong> 
                                                <span class="text-muted">requested 5 days ago</span>
                                            </div>
                                            <div class="panel-body">
                                             Clinic: @{{ appointment.clinic.name }}
                                             <br>
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
                                                                  
                                              <button  v-if="appointment.confirmed == 1 && appointment.re_schedule_by_id != authUser.id" type="button" class="btn btn-primary btn-success" @click="newConsultation(appointment)">Consult</button>

                                               <button  v-if="appointment.confirmed == 1 && appointment.re_schedule_by_id == authUser.id" type="button" class="btn btn-primary btn-success disabled" @click="newConsultation(appointment)">Consult</button>

                                              <button  v-if="appointment.confirmed == 2" type="button" class="btn btn-primary btn-success disabled" >Consult</button>
                                              <button type="button" class="btn btn-primary btn-infor"  data-title="Re-Schedule" data-toggle="modal" data-target="#reschedule" @click="setAppointmentChild(appointment)">Re-Schedule</button>
                                              <button type="button" class="btn btn-primary btn-danger" @click="deleteAppointment(appointment, $event)">Delete</button>
                                            </div>   

                                             
                                        </div><!-- /col-sm-1 -->

                                        <!-- /col-sm-5 -->
                                    </div> 











                                <br>
                                <div v-show="showLoadMoreBtn" class="row loadmore-container" style="text-align:center;">
                                    <button value="Load More" @click="loadMore()" style="width:30%;" class="btn btn-primary ladda-button loader" data-style="expand-left"><span class="ladda-label">Load More</span></button>      
                                </div>        













                </div>
            </div>

    </div>
</div>


<re-schedule :appointment="editAppointment" ></re-schedule>





@endsection




@section('javascripts')
    <script>
        $( function() {
            $( "#accordion" ).accordion();
        });

        var childMixin = {

            mounted(){
                
            },
            created: function() {
                this.fetchAllUserAppointments();                
            },



            data: function(){
                return {
                   schedule : {},   
                   appointments : {},  
                   appoinment_id : 0,
                   editAppointment : {},

                   lastdate : "",
                   showLoadMoreBtn : true, 
                   consultations : {},
                }
            },

            methods:{

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

                    self = this;

                    
                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, continue!'
                    }).then(function (isConfirm) {

                            if(isConfirm){
                                self.$http.post('/api/appointment/confirm/post', appointment, function(data){
                                    if(data == 'success'){
                                        appointment.confirmed = 1;
                                    }else{
                                        swal("Error","Please try again!", "error");
                                    }
                                });
                    

                            }
                            else
                            {
                                swal("cancelled","Your categories are safe", "error");
                            }

                    
                    });
                },

                fetchAllUserAppointments: function(){
                    this.$http.get('/api/appointments/get?lastdate='+this.lastdate, function(data){
                        this.appointments = data['appointments'];
                    });
                },

                consult : function(appointment){
                  /*  this.$http.post('/api/appointment/consult/post', appointment, function(data){
                        if(data == 'success'){
                        appointment.confirmed = 2;
                        }else{
                        swal("Error","Please try again!", "error");
                        }
                    });*/
                },

                newConsultation: function(appointment){
                    var inputOptions = new Promise(function (resolve) {
                    setTimeout(function () {
                        resolve({
                        '0': 'Checkup',
                        '1': 'Admit',
                        })
                    }, 1000)
                    })

                    

                    swal({
                        title: 'Select consultaion type',
                        input: 'radio',
                        confirmButtonText: 'Create',
                        inputOptions: inputOptions,
                        inputValidator: function (result) {
                            return new Promise(function (resolve, reject) {
                            if (result) {
                                resolve()
                            } else {
                                reject('You need to select something!')
                            }
                            })
                        }
                    }).then(function (result) {
                        window.location = '/itr/create/'+result+'/'+appointment.patient_id;
                    })
                   
                },

                reschedAppointment : function(appointment, event){
                    event.preventDefault();

                },

                loadMore: function(){
                    var lastitem = this.appointments[Object.keys(this.appointments)[Object.keys(this.appointments).length - 1]];
                    this.lastdate = lastitem.created_at;
                    self = this;
                    var l = Ladda.create(document.querySelector( '.loader' ));
                    l.start();
                    this.$http.get('/api/appointments/get?lastdate='+this.lastdate, function(data){
                        var items = data['appointments'];
                        if(data['remaining'] == 0){
                            self.showLoadMoreBtn = false;
                        }

                        if(data['error'] == 'Unauthenticated'){
                            windows.location = 'http://hidok.com';
                        }

                        items.forEach(function(item , index){
                            self.appointments.push(item);
                        });
                        l.stop();
                    });
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


  

            }

        };
    </script>
@endsection