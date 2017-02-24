@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Individual Treatment Record</div>

                <div class="panel-body">

                    <div id="accordion">
                      
                       @foreach ($appointments as $appointment)
                          <h3>{{ $appointment->appointment_date }}</h3>
                          <div>
                            <p>
                                    








                                <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel with-nav-tabs panel-default">
                                                <div class="panel-heading">
                                                        <ul class="nav nav-tabs">
                                                            <li class="active"><a href="#tab1default-{{ $appointment->id }}" data-toggle="tab"><i class="glyphicon glyphicon-edit"></i>Assessment</a></li>
                                                            <li><a href="#tab2default-{{ $appointment->id }}" data-toggle="tab"><i class="glyphicon glyphicon-user"></i>Labs</a></li>
                                                            <li><a href="#tab3default-{{ $appointment->id }}" data-toggle="tab"><i class="glyphicon glyphicon-print"></i>diagnosis</a></li>
                                                            <li><a href="#tab4default-{{ $appointment->id }}" data-toggle="tab"><i class="glyphicon glyphicon-leaf"></i>Treatment</a></li>
                                                    
                                                
                                                        </ul>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade in active" id="tab1default-{{ $appointment->id }}">

                                                        <!--
                                                                <div class="col-sm-12 well">
                                                                    <form accept-charset="UTF-8" action="" method="POST">
                                                                        <textarea class="form-control" v-model="appointmentITR['{!! $appointment->id !!}'].assessment" id="text" name="text" placeholder="Type in your message" rows="5"></textarea>
                                                                        <h6 class="pull-right" id="count_message"></h6>
                                                                        <button class="btn btn-info" type="submit">Update</button>
                                                                    </form>
                                                                </div>-->

                                                            <assessment-form v-for="itr in appointmentITR['{!! $appointment->id !!}']" :itr_id=itr.id :assessment=itr.assessment></assessment-form>       



                                                        </div>
                                                                    


                                                        <div class="tab-pane fade" id="tab2default-{{ $appointment->id }}">

                                                                
                                                                    <!-- <div class="col-sm-12 well">
                                                                        <form accept-charset="UTF-8" action="" method="POST">
                                                                            <textarea class="form-control" id="text" name="text" placeholder="Type in your message" rows="5"></textarea>
                                                                            <h6 class="pull-right" id="count_message"></h6>
                                                                            <button class="btn btn-info" type="submit">Update</button>
                                                                        </form>
                                                                    </div> -->

                                                                    <laboratory-form v-for="itr in appointmentITR['{!! $appointment->id !!}']" :itr_id=itr.id :laboratory=itr.laboratory></laboratory-form>   


                                                        </div>


                                                        <div class="tab-pane fade" id="tab3default-{{ $appointment->id }}">

                                                              <!--  <div class="col-sm-12 well">
                                                                    <form accept-charset="UTF-8" action="" method="POST">
                                                                        <textarea class="form-control" id="text" name="text" placeholder="Type in your message" rows="5"></textarea>
                                                                        <h6 class="pull-right" id="count_message"></h6>
                                                                        <button class="btn btn-info" type="submit">Update</button>
                                                                    </form>
                                                                </div> -->

                                                                <diagnosis-form v-for="itr in appointmentITR['{!! $appointment->id !!}']" :itr_id=itr.id :diagnosis=itr.diagnosis></diagnosis-form>


                                                        </div>
                                                     
                                                        <div class="tab-pane fade" id="tab4default-{{ $appointment->id }}">


                                                           <!--  <div class="col-sm-12 well">
                                                                <form accept-charset="UTF-8" action="" method="POST">
                                                                    <textarea class="form-control" id="text" name="text" placeholder="Type in your message" rows="5"></textarea>
                                                                    <h6 class="pull-right" id="count_message"></h6>
                                                                    <button class="btn btn-info" type="submit">Update</button>
                                                                </form>
                                                            </div> -->

                                                            <treatment-form v-for="itr in appointmentITR['{!! $appointment->id !!}']" :itr_id=itr.id :treatment=itr.treatment></treatment-form>


                                                        </div>
                                                                     
                                         
                                               







                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                                
                                 </div>




































































                            </p>
                          </div>
                       @endforeach
                     
                    </div>




                </div>
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

            mounted(){
                    
            },
            created: function() {    
                this.fetchPatientITR({!! $user->id !!}); 
            },



            data: function(){
                return {
                    appointmentITR : {}
                }
            },

            methods:{
                fetchConsultedAppointment: function(){
                    this.$http.get('/api/appointment/consult/get', function(data){
                        this.appointments = data['appointments'];
                    });
                },


                fetchPatientITR : function(id){

                  this.$http.get('/api/patient/itr/get/'+id, function(data){
                    this.appointmentITR = data['appointment_itr'];
        // /            alert(JSON.stringify(data['appointment_itr']['1']));
                  });
                },

            }

        };
    </script>
@endsection