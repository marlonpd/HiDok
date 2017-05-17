@extends('layout')

@section('content')
<div class="container">
    <div class="row">
           <div class="panel panel-default">
                <div class="panel-heading">Create ITR {{ $patient->firstname }}</div>
                <div class="panel-body">

                        <div id="accordion">
                            <h3>Chief Complaint</h3>
                            <div>
                                <p>
                                    <div class="row">
                                        <template v-for="symptom in selectedSymptoms">
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    <i @click="deleteChiefComplaint(symptom)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ symptom.symptom }}</label>
                                                </div>
                                            </div>
                                        </template>

                                       

                                        <div class="col-md-4"> 
                                              <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-symptoms-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        </div>


                                </div>

                                </p>
                            </div>

                            <h3>Vital Signs</h3>
                            <div>
                                <p>
                                    <vital-signs-set consultation_id="{!! $consultation->id !!}"></vital-signs-set>    
                                </p>
                            </div>

                            <h3>Brief History of Present Illness</h3>
                            <div>
                                <p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment"></textarea>
                                    </div>     
                                </p>
                            </div>

                            <h3>Past Medical History</h3>
                            <div>
                                <p>
                                <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment"></textarea>
                                    </div>          
                                </p>
                            </div>

                            <h3>Physical Exam</h3>
                            <div>
                                <p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment"></textarea>
                                    </div> 
                                </p>
                            </div>

                            <h3>Laboratory</h3>
                            <div>
                                <p>
                                <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment"></textarea>
                                    </div>  
                                </p>
                            </div>


                            <h3>Diagnosis</h3>
                            <div>
                                <p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment"></textarea>
                                    </div>       
                                </p>
                            </div>



                            <h3>Treatment</h3>
                            <div>
                                <p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment"></textarea>
                                    </div>       
                                </p>
                            </div>

                        </div>

                        <!--- End accordion -->

                        <div class="span6 pull-right">
                           <button class="btn btn-primary btn-danger btn-default" data-title="Create" data-toggle="modal" data-target="#create-clinic-form" ><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Cancel</button>
                        </div>  

                </div>
           </div>     
    </div>
</div>


<add-symptoms-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :symptoms="symptoms"></add-symptoms-form>
@endsection





@section('javascripts')
    <script>

        $( function() {
            $( "#accordion" ).accordion();
        });





        var childMixin = {

            mounted() {
                this.fetchSymptoms();
            },

            created: function() {
                
            },

            data(){
                return {
                    appointments : {},
                    appointment : {},
                    editAppointment : {},
                    appointmentITR : {},
                    symptoms: {},
                    selectedSymptoms: {},
                    checked : "1",
                }
            },

            events: {

            },

            methods: {

                setAppointmentMain : function(appointment){
                    this.editAppointment = appointment;
                    Vue.nextTick(function () {});
                },

                fetchChiefComplaint: function(){
                    this.$http.get('/api/chief/complaint/get/{!! $consultation->id !!}', function(data){
                        this.selectedSymptoms = data['symptoms'];
                    });
                },

                deleteChiefComplaint : function(symptom){
                    self = this;
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
                            self.$http.post('/api/symptom/delete/post', symptom ,function(data){
                                if(data['status']=='success'){
                                    this.fetchChiefComplaint();
                                }                      
                            });
                        }
                        else
                        {
                                swal("cancelled","Your categories are safe", "error");
                        }
                    });


         
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

                OnDataSave: function(id , field, value , table , event){
                    clearTimeout(this.timer);
                    this.timer = setTimeout(function() {
                        var captionClass = '.tm-lbl-'+field;
                        var caption = vm.fieldLabels[table+'-'+field];
                        var value = (typeof event.target.value === 'undefined') ? '' : event.target.value;


                        if(vm.olderValue != value ){
                            vm.olderValue = '';
                            var data = {  'id' :id , 'field' :field , 'value' : value };
                            vm.HttpPost(data, table , captionClass ,caption);
                        }
                    }, 2000);

                },

                fetchSymptoms: function(){
                    this.$http.get('/api/symptoms/get',function(data){
                        this.symptoms = data['symptoms'];        
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
      
            },



        };
    </script>
@endsection

