@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Appointments</div>

                <div class="panel-body">

                    <div id="accordion">
                      
                       @foreach ($clinics as $clinic)
                          <h3>{{ $clinic->name }}, {{ $clinic->address }}, {{ $clinic->from_day }}-{{ $clinic->to_day }} @ {{ $clinic->from_time }} - {{ $clinic->to_time }}</h3>
                          <div>
                            <p>
                                <schedule-appointment :clinic_id={!! $clinic->id !!} :appointments = appointments[{!! $clinic->id !!}] ></schedule-appointment>
                            </p>
                          </div>
                       @endforeach
                     
                    </div>



                    @{{ editAppointment | json }}

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
                this.fetchAllAppointments();                
            },



            data: function(){
                return {
                   schedule : {},   
                   appointments : {},  
                   appoinment_id : 0,
                   editAppointment : {},
                }
            },

            methods:{

                setAppointmentMain : function(appointment){
                    this.editAppointment = appointment;
                    Vue.nextTick(function () {});

               


                },

                fetchAllAppointments: function(){
                    this.$http.get('/api/auth/appointment/all/get', function(data){
                        this.appointments = data['appointments'];
                    });
                },


  

            }

        };
    </script>
@endsection