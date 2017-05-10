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
            mounted() {},

            created: function() {
            },

            data(){
                return {
                    appointments : {},
                    appointment : {},
                    editAppointment : {},
                    appointmentITR : {}
                }
            },

            events: {},

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
                    }).then(function (isConfirm,appointment) {
                      if(isConfirm){
                        self.$http.post('/api/appointment/delete/post', thisAppointment.id, function(data){
                          if(data == "success"){
                            swal('Deleted!','Your item has been deleted.','success');
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

