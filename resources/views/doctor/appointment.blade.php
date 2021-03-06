@extends('layout')

@section('content')
<div class="container">
    <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Appointments
                
                <div class="pull-right">
                    <input type="text" class="form-control input-md" name="searchKey" v-model="searchKey" />
                </div>

                <div class="clr"></div>

                </div>

                <div class="panel-body">

                  
                            <div class="shadow"  v-for="appointment in filterBy(appointments,searchKey)" >
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="thumbnail">         
                                        <img :src="appointment.patient.thumbnail" width="60px">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <a :href="'/patient/consultations/'+appointment.patient.id"><strong> @{{ appointment.patient.lastname }} , @{{ appointment.patient.firstname  }}</strong></a> 
                                            
                                        </div>
                                        <div class="panel-body">
                                            
                                             Clinic: @{{ appointment.clinic.name }}
                                             <br>
                                             @{{ appointment.appointment_date }}
                                             <br>
                                             Note: @{{ appointment.note }}

                                        </div><!-- /panel-body -->
                                    </div><!-- /panel panel-default -->
                                </div><!-- /col-sm-6 -->
                                
                                <div class="col-sm-5">
                                        <button  v-if="appointment.confirmed == 0 && appointment.re_schedule_by_id != authUser.id" type="button" class="btn btn-primary btn-success" @click="confirmAppointment(appointment, $event)"> Confirm</button>

                                        <button  v-if="appointment.confirmed == 0 && appointment.re_schedule_by_id == authUser.id" type="button" class="btn btn-primary btn-success disabled" @click="confirmAppointment(appointment, $event)">Confirm</button>
                                                            
                                        <button  v-if="appointment.confirmed == 1 && appointment.re_schedule_by_id != authUser.id" type="button" class="btn btn-primary btn-success" @click="newConsultation(appointment)">Consult</button>

                                        <button  v-if="appointment.confirmed == 1 && appointment.re_schedule_by_id == authUser.id" type="button" class="btn btn-primary btn-success" @click="newConsultation(appointment)">Consult</button>

                                        <button  v-if="appointment.confirmed == 2" type="button" class="btn btn-primary btn-success disabled" >Consult</button>
                                        <button  v-if="appointment.confirmed == 0" type="button" class="btn btn-primary btn-infor"  data-title="Re-Schedule" data-toggle="modal" data-target="#reschedule" @click="setAppointmentChild(appointment)">Re-Schedule</button>
                                        <button type="button" class="btn btn-primary btn-danger" @click="deleteAppointment(appointment, $event)">Cancel</button>
                                 </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr />
                            <div class="clearfix"></div>
                        </div>


                </div>

                 <br>
                <div v-if="showLoadMoreBtn" class="row loadmore-container" style="text-align:center;">
                    <button value="Load More" @click="loadMore()" style="width:30%;" class="btn btn-primary ladda-button loader" data-style="expand-left"><span class="ladda-label">Load More</span></button>      
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
                   searchKey : '',
                }
            },


            methods:{

                search: function(){
                    self = this;
                    clearTimeout(this.timer);
                    this.timer = setTimeout(function() {
                        self.fetchAllUserAppointments();
                    }, 2000);
                },

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
                    this.$http.get('/api/appointments/get?lastdate='+this.lastdate+'&key='+this.searchKey, function(data){
                        this.appointments = data['appointments'];
                        if(data['remaining'] == 0){
                            this.showLoadMoreBtn = false;
                        }
                    });
                },

                consult : function(appointment){
                },

                newConsultation: function(appointment){
                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this",
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, continue!'
                    }).then(function (isConfirm) {

                            if(isConfirm){
                                 window.location = '/consultation/create/0/'+appointment.patient_id+'/'+appointment.id;
                            }else{
                                swal("cancelled","Your categories are safe", "error");
                            }
                    
                    });
                   
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
                    this.$http.get('/api/appointments/get?lastdate='+this.lastdate+'&key='+this.searchKey, function(data){
                        var items = data['appointments'];
                        
                        if(data['remaining'] == 0){
                            this.showLoadMoreBtn = false;
                        }

                        if(data['error'] == 'Unauthenticated'){
                            windows.location = 'http://'+this.APP_DOMAIN;
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

                                    this.fetchAllUserAppointments();
                                   
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