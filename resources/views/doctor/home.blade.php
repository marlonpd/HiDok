@extends('layout')

@section('content')
<div class="container">
    <div class="row">
           <div class="panel panel-default">
                <div class="panel-heading">Home</div>
                <div class="panel-body">
                    test
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
           </div>     
    </div>
</div>
@endsection





@section('javascripts')
    <script>

        var childMixin = {

            mounted() {
            },

            created: function() {},

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

