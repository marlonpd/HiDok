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
                                    <div class="row">
                                        <template v-for="vitalSign in selectedVitalSigns">
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    <i @click="deleteVitalSigns(vitalSign)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ vitalSign.vital_sign }}</label>
                                                </div>
                                            </div>
                                        </template>

                                       

                                        <div class="col-md-4"> 
                                              <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-vital-signs-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        </div>
                                  </div>

                                </p>
                            </div>

                            <h3>Brief History of Present Illness</h3>
                            <div>
                                <p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment" v-model="itrTxt['bhpi']"></textarea>
                                    </div>     

                                    <div class="span6 pull-right">
                                        <button class="btn btn-primary btn-default loading"  @click="saveITR('bhpi')"><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Save</button>
                                    </div>  
                                </p>
                            </div>

                            <h3>Past Medical History</h3>
                            <div>
                                <p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment" v-model="itrTxt['pmh']"></textarea>
                                    </div>     

                                    <div class="span6 pull-right">
                                        <button class="btn btn-primary btn-default loading"  @click="saveITR('pmh')"><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Save</button>
                                    </div>  
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
                                     <div class="row">
                                        <template v-for="diagnose in diagnoses">
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    <i @click="deleteITRItem('diagnosis',diagnose)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ diagnose.value }}</label>
                                                </div>
                                            </div>
                                        </template>   

                                       

                                        <div class="col-md-4"> 
                                              <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-diagnosis-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        </div>
                                  </div>    
                                </p>
                            </div>



                            <h3>Treatment</h3>
                            <div>
                                <p>
                                    <div class="row">
                                        <template v-for='treatment in itr["treatment"]'>
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    <i @click="deleteITRItem('treatment',treatment)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ treatment.value }}</label>
                                                </div>
                                            </div>
                                        </template>   
                                    </div>   

                                    <div class="col-md-4"> 
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-treatment-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                    </div>
                                </p>
                            </div>

                            <h3>Other Medical Intervention</h3>
                            <div>
                                <p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment" v-model="itrTxt['omi']"></textarea>
                                    </div>     

                                    <div class="span6 pull-right">
                                        <button class="btn btn-primary btn-default loading"  @click="saveITR('omi')"><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Save</button>
                                    </div>  
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


<add-symptoms-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :symptoms="terms['symptom']"></add-symptoms-form>
<add-vitalsigns-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :vitalsigns="terms['vital_sign']"></add-vitalsigns-form>
<add-diagnosis-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :diagnosis="terms['diagnosis']"></add-diagnosis-form>
<add-treatment-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :treatment="terms['treatment']"></add-treatment-form>

@endsection





@section('javascripts')
    <script>

        $( function() {
            $( "#accordion" ).accordion();
        });





        var childMixin = {

            mounted() {
                this.fetchSymptoms();
                this.fetchTerms();
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
                    vitalsigns: {},
                    selectedVitalSigns: {},
                    selectedDiagnosis:{},
                    itrTxt: {
                        bhpi : '',
                        pmh : '',
                        omi:'',
                    },
                    //see config/constants.php for the definition    
                    terms:{
                        vital_sign    : null,
			            symptom       : null,
			            diagnosis     : null,
			            treatment     : null,
			            laboratory    : null,
			            physical_exam : null,
                    },
                    itr: {
                        d    : null,  
                        vs   : null, 
                        bhpi : null,
                        pmh  : null,
                        pe   : null,
                        l    : null,
                        treatment    : null,
                        omi  : null,
                    },
                    diagnoses : {},

                }
            },

            events: {

            },

            methods: {
                saveITR: function(type){
                    var data = {
                            value : this.itrTxt[type],
                            type : type,
                            consultation_id : '{!! $consultation->id !!}',
                            patient_id : '{!! $consultation->patient_id !!}',
                    };

                    var l = Ladda.create(document.querySelector( '.loading' ));
                    l.start();

                    this.$http.post('/api/itr/post',data,function(data){
                        if(data['status'] == 'success'){
                        swal({
                          title: 'Success!',
                          text: 'Data saved.',
                          showConfirmButton : false,
                          timer: 500,
                          type : 'success',
                        }).then(function () {},function (dismiss) {});
                            l.stop();
                        }

                    });
                },

                setAppointmentMain : function(appointment){
                    this.editAppointment = appointment;
                    Vue.nextTick(function () {});
                },

                fetchChiefComplaint: function(){
                    this.$http.get('/api/chief/complaint/get/{!! $consultation->id !!}', function(data){
                        this.selectedSymptoms = data['symptoms'];
                    });
                },

                fetchVitalSigns: function(){
                    this.$http.get('/api/vitalsign/get/{!! $consultation->id !!}', function(data){
                        this.selectedVitalSigns = data['vital_signs'];
                    });
                },

                fetchTerms: function(){
                    this.$http.get('/api/terms/get',function(data){
                        this.vitalsigns = data['vital_sign'];
                        //this.diagnosis = data['diagnosis'];
                        this.terms = data;
                        
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

                deleteITRItem : function(type,value){
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
                            self.$http.post('/api/itr/delete/post', value ,function(data){
                                if(data['status']=='success'){
                                    this.fetchITR(type);
                                }                      
                            });
                        }
                        else
                        {
                                swal("cancelled","Your categories are safe", "error");
                        }
                    });


         
                },

                fetchITR: function(type){
                    this.$http.get('/api/itr/get/{!! $consultation->id !!}/'+type ,function(data){
                        this.itr[type] = data[type];
                        this.diagnoses = data['diagnosis'];
                    });
                },


                deleteVitalSigns : function(vitalSign){
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
                            self.$http.post('/api/vital/sign/delete/post', vitalSign ,function(data){
                                if(data['status']=='success'){
                                    this.fetchVitalSigns();
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

