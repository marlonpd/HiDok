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
                                                    <i @click="deleteITRItem('chief_complaint',symptom)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ symptom.value }}</label>
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
                                                    <i @click="deleteITRItem('vital_sign',vitalSign)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ vitalSign.value }}</label>
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
                                        <button class="btn btn-primary btn-default bhpi-loading"  @click="saveITR('bhpi')"><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Save</button>
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
                                        <button class="btn btn-primary btn-default pmh-loading"  @click="saveITR('pmh')"><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Save</button>
                                    </div>  
                            </div>

                            <h3>Physical Exam</h3>
                            <div>
                                <p>
                                    <div>
                                        <h4>General Appearances</h4>
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-general-appearances-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        <hr>
                                            <div class="row">
                                                <template v-for='ga in selectedGeneralAppearances'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <i @click="deleteITRItem('general_appearance',ga)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ ga.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>

                                    <div>
                                        <h4>Skin</h4>
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-skins-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        <hr>
                                            <div class="row">
                                                <template v-for='skin in selectedSkins'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <i @click="deleteITRItem('skin',skin)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ skin.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>

                                    <div>
                                        <h4>Heent</h4>
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-heent-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        <hr>
                                            <div class="row">
                                                <template v-for='heent in selectedHeents'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <i @click="deleteITRItem('heent',heent)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ heent.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>

                                    <div>
                                        <h4>Neck</h4>
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-necks-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        <hr>
                                            <div class="row">
                                                <template v-for='neck in selectedNecks'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <i @click="deleteITRItem('neck',neck)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ neck.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>


                                    <div>
                                        <h4>Chest and Lungs</h4>
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-chest-and-lungs-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        <hr>
                                            <div class="row">
                                                <template v-for='cl in selectedChestAndLungs'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <i @click="deleteITRItem('chest_and_lungs',cl)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ cl.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>


                                    <div>
                                        <h4>Cardiovascular Systems</h4>
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-cardiovascular-systems-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        <hr>
                                            <div class="row">
                                                <template v-for='cs in selectedCardiovascularSystems'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <i @click="deleteITRItem('cardiovascular_system',cs)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ cs.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>

                                    <div>
                                        <h4>Abdomen</h4>
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-abdomen-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        <hr>
                                            <div class="row">
                                                <template v-for='abdomen in selectedAbdomens'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <i @click="deleteITRItem('abdomen',abdomen)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ abdomen.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>


                                    <div>
                                        <h4>Genito-Urinary System</h4>
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-genito-urinary-system-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        <hr>
                                            <div class="row">
                                                <template v-for='gus in selectedGenitoUrinarySystems'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <i @click="deleteITRItem('genito_urinary_system',gus)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ gus.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>


                                    <div>
                                        <h4>Extremities</h4>
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-extremity-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        <hr>
                                            <div class="row">
                                                <template v-for='extremity in selectedExtremities'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <i @click="deleteITRItem('extremities',extremity)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ extremity.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>

                                    
                                </p>
                            </div>

                            <h3>Laboratory</h3>
                            <div>
                                <p>
                                     <div class="row">
                                        <template v-for='laboratory in selectedLaboratory'>
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    <i @click="deleteITRItem('laboratory',laboratory)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i><label> @{{ laboratory.value }}</label>
                                                </div>
                                            </div>
                                        </template>   
                                    </div>   

                                    <div class="col-md-4"> 
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-laboratory-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
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
                                        <button class="btn btn-primary btn-default omi-loading"  @click="saveITR('omi')"><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Save</button>
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



<add-symptoms-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :symptoms="symptoms"></add-symptoms-form>
<add-vitalsigns-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :vitalsigns="vitalsigns"></add-vitalsigns-form>
<add-diagnosis-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :diagnose="diagnose"></add-diagnosis-form>
<add-treatment-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :treatment="terms['treatment']"></add-treatment-form>
<add-laboratory-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :laboratories="laboratories"></add-laboratory-form>
<add-general-appearances-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :general_appearances="generalAppearances"></add-general-appearances-form>
<add-skins-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :skins="skins"></add-skins-form>
<add-heent-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :heents="heents"></add-heent-form>
<add-neck-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :necks="necks"></add-neck-form>


<add-chest-and-lungs-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :chestandlungs="chestAndLungs"></add-chest-and-lungs-form>
<add-cardiovascular-system-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :cardiovascularSystems="cardiovascularSystems"></add-cardiovascular-system-form>
<add-abdomen-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :abdomens="abdomens"></add-abdomen-form>
<add-genito-urinary-system-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :genitourinarysystems="genitoUrinarySystems"></add-genito-urinary-system-form>
<add-extremity-form :consultation_id="'{{ $consultation->id }}'" :patient_id="'{{ $patient->id }}'" :extremities="extremities"></add-extremity-form>



@endsection





@section('javascripts')
    <script>

        $( function() {
            $( "#accordion" ).accordion();
        });

        var childMixin = {

            mounted() {
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
                    skins : {},
                    heents : {},
                    necks : {},
                    chestAndLungs : {},
                    cardiovascularSystems : {},
                    abdomens : {},
                    genitoUrinarySystems : {},
                    extremities : {},
                    selectedSymptoms: {},
                    selectedSkins: {},
                    vitalsigns: {},
                    selectedVitalSigns: {},
                    selectedDiagnosis:{},
                    selectedLaboratory :{},
                    selectedGeneralAppearances :{},

                    selectedHeents : {},
                    selectedNecks : {},
                    selectedChestAndLungs : {},
                    selectedCardiovascularSystems : {},
                    selectedAbdomens : {},
                    selectedGenitoUrinarySystems : {},
                    selectedExtremities : {},

                    vitalSignTerms : [],
                    diagnose : {},
                    generalAppearances : {},


                    itrTxt: {
                        bhpi : '',
                        pmh : '',
                        omi:'',
                    },
                    //see config/constants.php for the definition    
                    terms:{
                        vital_sign    : null,
			            symptom       : null,
                        skin          : null,
			            diagnosis     : null,
			            treatment     : null,
			            laboratory    : null,
			            physical_exam : null,
                    },
                    itr: {
                        diagnosis    : null,  
                        vital_sign   : null, 
                        symptom : null,
                        skin  : null,
                        laboratory   : null,
                        general_appearance    : null,
                        treatment    : null,
                        heent  : null,
                        neck : null,
                        chest_and_lungs : null,
                        cardiovascular_system : null,
                        abdomen : null,
                        genito_urinary_system : null,
                        extremities : null,
                    },
                    diagnoses : {},

                }
            },

            events: {

            },

            methods: {
                getFiles: function(obj){
                    console.log(obj);
                },
                
                saveITR: function(type){
                    var data = {
                            value : this.itrTxt[type],
                            type : type,
                            consultation_id : '{!! $consultation->id !!}',
                            patient_id : '{!! $consultation->patient_id !!}',
                    };

                    var l = Ladda.create(document.querySelector( '.'+type+'-loading' ));
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
                            $( '.'+type+'-loading' ).removeClass('ladda-button');
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
                        this.vitalSignTerms = data['vital_sign'];
                        this.terms = data;
                        this.symptoms = data['symptom'];
                        this.laboratories = data['laboratory'];
                        this.diagnose = data['diagnosis'];
                        this.skins = data['skin'];
                        this.generalAppearances = data['general_appearance'];
                        this.heents = data['heent'];
                        this.necks = data['neck'];
                        this.chestAndLungs = data['chest_and_lungs'];
                        this.cardiovascularSystems= data['cardiovascular_system'];
                        this.abdomens = data['abdomen'];
                        this.genitoUrinarySystems = data['genito_urinary_system'];
                        this.extremities = data['extremities'];
                        
                         $('#vital-sign-autocomplete').autoComplete({
                            minChars: 1,
                            source: function(term, suggest){
                                term = term.toLowerCase();
                                var choices =data['vital_sign'];
                                var suggestions = [];
                                var i=0;
                                for (i=0;i<choices.length;i++)
                                    if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                                suggest(suggestions);
                            }
                        });

                        $('#treatment-autocomplete').autoComplete({
                            minChars: 1,
                            source: function(term, suggest){
                                term = term.toLowerCase();
                                var choices =data['treatment'];
                                var suggestions = [];
                                var i=0;
                                for (i=0;i<choices.length;i++)
                                    if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                                suggest(suggestions);
                            },

                            
                        });

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
                                swal("Error","Please, try again!", "error");
                        }
                    });


         
                },

                fetchITR: function(type){
                    this.$http.get('/api/itr/get/{!! $consultation->id !!}/'+type ,function(data){
                        this.itr[type] = data[type];
                        if(type == 'diagnosis'){
                             this.diagnoses = data['diagnosis'];
                        }else if(type== 'vital_sign'){
                            this.selectedVitalSigns = data['vital_sign'];
                        }else if(type== 'chief_complaint'){
                            this.selectedSymptoms = data['chief_complaint'];
                        }else if(type== 'skin'){
                            this.selectedSkins = data['skin'];
                        }else if(type== 'laboratory'){
                            this.selectedLaboratory = data['laboratory'];
                        }else if(type== 'general_appearance'){
                            this.selectedGeneralAppearances = data['general_appearance'];
                        }else if(type== 'heent'){
                            this.selectedHeents = data['heent'];
                        }else if(type== 'neck'){
                            this.selectedNecks = data['neck'];
                        }else if(type== 'chest_and_lungs'){
                            this.selectedChestAndLungs = data['chest_and_lungs'];
                        }else if(type== 'cardiovascular_system'){
                            this.selectedCardiovascularSystems= data['cardiovascular_system'];
                        }else if(type== 'abdomen'){
                            this.selectedAbdomens = data['abdomen'];
                        }else if(type== 'genito_urinary_system'){
                            this.selectedGenitoUrinarySystems = data['genito_urinary_system'];
                        }else if(type== 'extremities'){
                            this.selectedExtremities = data['extremities'];
                        }     

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
                                swal("Error","Please, try again!", "error");
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
                                swal("Error","Please, try again!", "error");
                            }
                    });

                    
                },
      
            },



        };
    </script>
@endsection

