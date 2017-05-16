

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
                                                            <div v-for="itr in appointmentITR['{!! $appointment->id !!}']" v-html="itr.assessment"></div>       
                                                        </div>                                                                 
                                                        <div class="tab-pane fade" id="tab2default-{{ $appointment->id }}">
                                                            <div v-for="itr in appointmentITR['{!! $appointment->id !!}']"  v-html="itr.laboratory"></div>   
                                                        </div>
                                                        <div class="tab-pane fade" id="tab3default-{{ $appointment->id }}">
                                                            <div v-for="itr in appointmentITR['{!! $appointment->id !!}']"  v-html="itr.diagnosis"></div>
                                                        </div>
                                                        <div class="tab-pane fade" id="tab4default-{{ $appointment->id }}">
                                                            <div v-for="itr in appointmentITR['{!! $appointment->id !!}']"  v-html="itr.treatment"></div>
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
   
@section('javascripts')
    <script>
        $( function() {
            $( "#accordion" ).accordion();
        });

    </script>
@endsection