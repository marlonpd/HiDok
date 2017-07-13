@extends('layout')

@section('content')

<div class="container">
      <div class="row background-white">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
              <div class="col-md-3 pull-left">
                
                <div class="row"> 
                  <div class="thumbnail" align="center">  
                    <img alt="User Pic" src="/{{$patient->thumbnail}}" class="img-responsive"> 
                  </div>
                </div>

                     
                     

                 <span  class="row"> <h4 class="name-title">{{ $patient->fullname() }} </h4>
                    <a href="#" @click="toggleDiv('more-details' ,$event)" id="showdetails">Show Details</a>

                    <div id="more-details" style="">
                        <span class="row">Sex: {{ $patient->gender }}</span>
                        <span class="row">Height: {{ $patient->height }} </span>
                        <span class="row">Weight:  {{ $patient->weight }}</span>
                        <span class="row">Contact no.: {{ $patient->contact_no }}</span>
                        <span class="row">Address:  {{ $patient->address }}</span>
                        <span class="row">Bithdate: {{$patient->birthdate }}</span>
                    </div>      
                 </span>
                 
                 <span class="row">
                    @if(Auth::user()->is_doctor())
                        <a type="button" class="btn default-btn btn-block" @click="createConsultation($event)" href="#">New Consultation</a>
                    @endif
                 </span>

                 <div class="row consultations-pnl "  >
                        <div v-for="consultation in consultations" class="consultation-detail hand-pointer shadow" @click="viewConsultation(consultation, $event)">
                            <span>Date :  @{{ consultation.created_at }}</span><br>
                            <span>Dr: @{{ consultation.doctor.firstname }} @{{ consultation.doctor.lastname }}</span>
                        </div>

                        

                        <div class="clr"></div>

                        <br>
                        <div v-if="showLoadMoreBtn" class="row loadmore-container" style="text-align:center;">
                            <button value="Load More" @click="loadMore()" style="width:70%;" class="btn btn-primary ladda-button loader" data-style="expand-left"><span class="ladda-label">Load More</span></button>      
                        </div>
                 </div>
                
              </div>

              <div class="col-md-9 pull-left">
                     <!---Start Of Tabs -->
                        <div class="panel panel-default">
                <div class="panel-heading">
                    Consultation Date : @{{ consultation.created_at}}         
                    
                </div>

                <div class="panel-body">

                        <div id="accordion">
                            <h3>Chief Complaint</h3>
                            <div>
                                <p>
                                    <div class="row">
                                        <div class="pull-left"> 
                                              @if(Auth::user()->is_doctor())  
                                              <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-symptoms-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                              @endif
                                        </div>
                                        <div class=" clr"></div>
                                        <hr>
                                        <template v-for="symptom in itr['chief_complaint']">
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    @if(Auth::user()->is_doctor())
                                                    <i @click="deleteITRItem('chief_complaint',symptom)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                    @endif
                                                    <label> @{{ symptom.value }}</label>
                                                </div>
                                            </div>
                                        </template>

                                    
                                        
                                </div>

                                </p>
                            </div>

                            <h3>Vital Signs</h3>
                            <div>
                                <p>
                                    <div class="row">
                                        <div class="pull-left"> 
                                              @if(Auth::user()->is_doctor())  
                                                <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-vital-signs-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                              @endif
                                        </div>
                                        
                                        <div class=" clr"></div>
                                        <hr>
                                        <template v-for="vitalSign in itr['vital_sign']">
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    @if(Auth::user()->is_doctor())     
                                                        <i @click="deleteITRItem('vital_sign',vitalSign)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                    @endif
                                                    <label> @{{ vitalSign.value }}</label>
                                                </div>
                                            </div>
                                        </template>

                                       

                                        
                                  </div>

                                </p>
                            </div>

                            <h3>Brief History of Present Illness</h3>
                            <div>
                                <p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment" v-model="itr['present_illness_history']"></textarea>
                                    </div>     

                                    @if(Auth::user()->is_doctor())
                                    <div class="span6 pull-right">
                                        <button class="btn btn-primary btn-default present_illness_history-loading"  @click="saveITR('present_illness_history')"><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Save</button>
                                    </div>  
                                    @endif
                                </p>
                            </div>

                            <h3>Past Medical History</h3>
                            <div>
                                <p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment" v-model="itr['past_medical_history']"></textarea>
                                    </div>     

                                    @if(Auth::user()->is_doctor())
                                    <div class="span6 pull-right">
                                        <button class="btn btn-primary btn-default past_medical_history-loading"  @click="saveITR('past_medical_history')"><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Save</button>
                                    </div>  
                                    @endif
                            </div>

                            <h3>Physical Exam</h3>
                            <div>
                                <p>
                                    <div>
                                        <h4>General Appearances</h4>
                                        @if(Auth::user()->is_doctor())
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-general-appearances-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <hr>
                                            <div class="row">
                                                <template v-for="ga in itr['general_appearance']">
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                           @if(Auth::user()->is_doctor()) 
                                                           <i @click="deleteITRItem('general_appearance',ga)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                           @endif
                                                           <label> @{{ ga.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>

                                    <div>
                                        <h4>Skin</h4>
                                        @if(Auth::user()->is_doctor())
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-skins-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <hr>
                                            <div class="row">
                                                <template v-for='skin in itr["skin"]'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            @if(Auth::user()->is_doctor())
                                                            <i @click="deleteITRItem('skin',skin)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                            @endif
                                                            <label> @{{ skin.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>

                                    <div>
                                        <h4>Heent</h4>
                                        @if(Auth::user()->is_doctor())
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-heent-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <hr>
                                            <div class="row">
                                                <template v-for='heent in itr["heent"]'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            @if(Auth::user()->is_doctor())
                                                            <i @click="deleteITRItem('heent',heent)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                            @endif
                                                            <label> @{{ heent.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>

                                    <div>
                                        <h4>Neck</h4>
                                        @if(Auth::user()->is_doctor())
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-necks-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <hr>
                                            <div class="row">
                                                <template v-for='neck in itr["neck"]'>
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
                                        @if(Auth::user()->is_doctor())
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-chest-and-lungs-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <hr>
                                            <div class="row">
                                                <template v-for='cl in itr["chest_and_lungs"]'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            @if(Auth::user()->is_doctor())
                                                            <i @click="deleteITRItem('chest_and_lungs',cl)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                            @endif
                                                            <label> @{{ cl.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>


                                    <div>
                                        <h4>Cardiovascular Systems</h4>
                                        @if(Auth::user()->is_doctor())
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-cardiovascular-systems-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <hr>
                                            <div class="row">
                                                <template v-for='cs in itr["cardiovascular_system"]'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            @if(Auth::user()->is_doctor())
                                                            <i @click="deleteITRItem('cardiovascular_system',cs)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                            @endif
                                                            <label> @{{ cs.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>

                                    <div>
                                        <h4>Abdomen</h4>
                                        @if(Auth::user()->is_doctor())
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-abdomen-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <hr>
                                            <div class="row">
                                                <template v-for='abdomen in itr["abdomen"]'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            @if(Auth::user()->is_doctor())
                                                            <i @click="deleteITRItem('abdomen',abdomen)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                            @endif
                                                            <label> @{{ abdomen.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>


                                    <div>
                                        <h4>Genito-Urinary System</h4>
                                        @if(Auth::user()->is_doctor())
                                            <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-genito-urinary-system-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <hr>
                                            <div class="row">
                                                <template v-for='gus in itr["genito_urinary_system"]'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            @if(Auth::user()->is_doctor())
                                                            <i @click="deleteITRItem('genito_urinary_system',gus)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                            @endif
                                                            <label> @{{ gus.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>


                                    <div>
                                        <h4>Extremities</h4>
                                        @if(Auth::user()->is_doctor())
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-extremity-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <hr>
                                            <div class="row">
                                                <template v-for='extremity in itr["extremities"]'>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            @if(Auth::user()->is_doctor())
                                                            <i @click="deleteITRItem('extremities',extremity)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                            @endif
                                                            <label> @{{ extremity.value }}</label>
                                                        </div>
                                                    </div>
                                                </template>   
                                            </div>
                                    </div>

                                    
                                </p>
                            </div>

                            <h3>Diagnostic Tests</h3>
                            <div>
                                <p>

                                    <div class="pull-left"> 
                                        @if(Auth::user()->is_doctor())
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-laboratory-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <a class="btn btn-info" target="_blank" @click="print('laboratory',$event)" ><i class="fa fa-print" aria-hidden="true"></i>Print</a>
                                    </div>
                                    <div class="clr"></div>
                                    <hr>

                                     <div class="row">
                                        <template v-for='laboratory in itr["laboratory"]'>
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    @if(Auth::user()->is_doctor())
                                                    <i @click="deleteITRItem('laboratory',laboratory)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                    @endif
                                                    <label> @{{ laboratory.value }}</label>
                                                </div>
                                            </div>
                                        </template>   
                                    </div>   


                                </p>
                            </div>


                            <h3>Diagnosis</h3>
                            <div>
                                <p>
                                    <div class="pull-left"> 
                                        @if(Auth::user()->is_doctor())
                                            <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-diagnosis-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif    
                                    </div>
                                    <div class="clr"></div>
                                    <hr>
                                    
                                     <div class="row">
                                        <template v-for='diagnose in itr["diagnosis"]'>
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    @if(Auth::user()->is_doctor())
                                                    <i @click="deleteITRItem('diagnosis',diagnose)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                    @endif
                                                    <label> @{{ diagnose.value }}</label>
                                                </div>
                                            </div>
                                        </template>   

                                       

                                        
                                  </div>    
                                </p>
                            </div>



                            <h3>Treatment</h3>
                            <div>
                                <p>
                                    <div class="col-md-4"> 
                                        @if(Auth::user()->is_doctor())
                                        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#add-treatment-form" ><i class="fa fa-plus fa-1" aria-hidden="true"></i>Add</button>
                                        @endif
                                        <a class="btn btn-info" target="_blank" @click="print('treatment',$event)" ><i class="fa fa-print" aria-hidden="true"></i>Print</a>
                                    </div>
                                    <div class="clr"></div>
                                    <hr>

                                    <div class="row">
                                        <template v-for='treatment in itr["treatment"]'>
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    @if(Auth::user()->is_doctor())
                                                    <i @click="deleteITRItem('treatment',treatment)" class="hand-pointer fa fa-times-circle fa-1 color-red" aria-hidden="true"></i>
                                                    @endif
                                                    <label> @{{ treatment.value }}</label>
                                                </div>
                                            </div>
                                        </template>   
                                    </div>   

                                    
                                </p>
                            </div>

                            <h3>Other Medical Intervention</h3>
                            <div>
                                <p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="comment" v-model="itr['other_medical_intervention']"></textarea>
                                    </div>     

                                    
                                    @if(Auth::user()->is_doctor())    
                                    <div class="span6 pull-right">
                                        
                                        <button class="btn btn-primary btn-default other_medical_intervention-loading"  @click="saveITR('other_medical_intervention')"><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Save</button>
                                    </div>  
                                    @endif
                            </div>

                        </div>

                        

                        <!--- End accordion -->
                        <br>

                        @if(Auth::user()->is_doctor())
                        <div>
                            <span><input type="checkbox" v-model="consultation.admit" v-bind:true-value="1" v-bind:false-value="0" @click="admitPatient($event)"> Admint patient?</span> 
                            <span v-if="consultation.admit == 1">Hospital: <input type="text" v-model="consultation.hospital"  v-on:keyup="assignHospital($event)"></span>
                            <span v-if="consultation.admit == 1">(<a href="#" @click="print('doctors_order',$event)">doctor's order</a>)</span>
                        
                        </div>
                        @endif

                       

                </div>
           </div> <!-- End of Tabs -->   

                    @if(Auth::user()->is_doctor())
                    <div class="pull-right margin-sm">
                        <button type="button" class="btn btn-primary btn-danger" @click="deleteConsultation( $event)">Delete</button>       
                        <a class="btn btn-info" target="_blank" @click="print('consultation',$event)" ><i class="fa fa-print" aria-hidden="true"></i>Print</a>
                    </div>
                    @endif

                  </div>
              </div>

            </div>
       </div>
</div>



<add-symptoms-form :consultation_id=consultation.id :patient_id="'{{ $patient->id }}'" :symptoms="symptoms"></add-symptoms-form>
<add-vitalsigns-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :vitalsigns="vitalsigns"></add-vitalsigns-form>
<add-diagnosis-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :diagnose="diagnose"></add-diagnosis-form>
<add-treatment-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :treatment="terms['treatment']"></add-treatment-form>
<add-laboratory-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :laboratories="laboratories"></add-laboratory-form>
<add-general-appearances-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :general_appearances="generalAppearances"></add-general-appearances-form>
<add-skins-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :skins="skins"></add-skins-form>
<add-heent-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :heents="heents"></add-heent-form>
<add-neck-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :necks="necks"></add-neck-form>
<add-chest-and-lungs-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :chestandlungs="chestAndLungs"></add-chest-and-lungs-form>
<add-cardiovascular-system-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :cardiovascularSystems="cardiovascularSystems"></add-cardiovascular-system-form>
<add-abdomen-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :abdomens="abdomens"></add-abdomen-form>
<add-genito-urinary-system-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :genitourinarysystems="genitoUrinarySystems"></add-genito-urinary-system-form>
<add-extremity-form :consultation_id="consultation.id" :patient_id="'{{ $patient->id }}'" :extremities="extremities"></add-extremity-form>

@endsection

@section('javascripts')
    <script>
        $(function(){
            $( "#accordion" ).accordion();
        });

        var childMixin = {
            mounted() {},

            created: function() {
                this.fetchFirstConsultation();
                this.fetchTerms();
                //this.fetchITR();
            },

            data(){
                return {
                    lastdate : "",
                    showLoadMoreBtn : true, 
                    consultations : {},
                    appointments : {},
                    appointment : {},
                    editAppointment : {},
                    appointmentITR : {},
                    symptoms: {},
                    skins : {},
                    heents : {},
                    necks : {},
                    laboratories :{},
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
                        present_illness_history : {},
                    },
                    diagnoses : {},
                    itr  : {},
                    consultation :{},
                    remaining : 0,
                }
            },
            
            events: {},

            methods: {
                assignHospital: function(event){
                    event.preventDefault();
                    self = this; 
                    clearTimeout(this.timer);
                    this.timer = setTimeout(function() {
                        self.$http.post('/api/consultation/assign/hospital/post',self.consultation,function(data){
                            if(data['status'] == 'success'){
                                swal({
                                    title: 'Success!',
                                    text: 'Data saved.',
                                    showConfirmButton : false,
                                    timer: 500,
                                    type : 'success',
                                }).then(function () {},function (dismiss) {});
                            }else{
                                    swal("Error","Please try again!", "error");
                            }
                        });
                        
                    }, 2000);
                },

               admitPatient: function(event){
                    event.preventDefault();
                    this.$http.post('/api/consultation/admit/patient/post',this.consultation,function(data){
                        if(data['status'] == 'success'){
                            swal({
                                title: 'Success!',
                                text: 'Data saved.',
                                showConfirmButton : false,
                                timer: 500,
                                type : 'success',
                            }).then(function () {},function (dismiss) {});
                        }else{
                             swal("Error","Please try again!", "error");
                        }
                    });

                },

                deleteConsultation: function(event){
                    event.preventDefault();

                    self = this;
                    
                    swal({
                        title: 'Are you sure?',
                        text: "You are about to delete the selected consultation!",
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, continue!'
                    }).then(function (isConfirm) {
                            if(isConfirm){
                                self.$http.post('/api/consultation/delete/post', self.consultation, function(data){
                                        self.fetchUserConsultations();
                                });
                            }else
                            {
                                swal("cancelled","Please try again!", "error");
                            }

                    
                    });

                    

                },

                toggleDiv: function(panel, event){
                    
                    var content = $('#showdetails').html();

                    if(content == 'Show Details'){  
                        $('#showdetails').html('Hide Details');    
                    }else{
                        $('#showdetails').html('Show Details');
                    }

                    event.preventDefault();
                    $("#"+panel).toggle();
                
                
                },

                print: function(type, event){
                    event.preventDefault();
                    window.open('/print/'+type+'/'+this.consultation.id+'/'+this.consultation.patient_id+'', '_blank', 'location=yes,height=370,width=450,scrollbars=yes,status=yes');
                },

                fetchFirstConsultation: function(){
                    this.$http.get('/api/consultations/get?lastdate='+this.lastdate+'&patient_id={!! $patient->id!!}', function(data){
                        this.consultations = data['consultations'];
                        this.consultation = this.consultations[0];
                        this.fetchITR('all');
                        this.remaining = data['remaining'];
                        if(this.remaining > 0 ){
                            this.showLoadMoreBtn = true;
                        }else{
                            this.showLoadMoreBtn = false;
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
                
                saveITR: function(type){
                    var data = {
                            value : this.itr[type],
                            type : type,
                            consultation_id : this.consultation.id,
                            patient_id :this.consultation.patient_id,
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

                createConsultation: function(event){
                    event.preventDefault();
                    var data = {patient_id : '{!! $patient->id!!}' };
                    self = this;         
                    swal({
                        title: 'Are you sure?',
                        text: "You are about to create new consultation!",
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, continue!'
                    }).then(function (isConfirm) {
                            if(isConfirm){
                                self.$http.post('/api/consultation/create', data ,function(data){
                                    if(data['status'] == 'success'){
                                        self.consultations.unshift(data['consultation']);
                                    }else{
                                        alert('Please try again!');
                                    }
                                });
                            }
                            else
                            {
                                swal("cancelled","Your categories are safe", "error");
                            }

                    
                    });
                },

                viewConsultation(consultation, event){
                    var clickedElement =event.target;
                    $(clickedElement).siblings().removeClass('consultation-active');
                    $(clickedElement).addClass('consultation-active');
                    this.consultation = consultation;
                    this.$http.get('/api/itr/get/'+consultation.id+'/all', function(data){
                        this.itr = data['itr'];
                        if(this.itr['present_illness_history'].length > 0 ){
                            this.itr['present_illness_history'] = this.itr['present_illness_history'][0].value;
                        }else{
                            this.itr['present_illness_history']  = '';
                        }
                        if(this.itr['past_medical_history'].length > 0){
                                this.itr['past_medical_history'] = this.itr['past_medical_history'][0].value;
                        }else{
                                this.itr['past_medical_history'] = '';
                        }
                        if(this.itr['other_medical_intervention'].length > 0 ){
                                this.itr['other_medical_intervention'] = this.itr['other_medical_intervention'][0].value;
                        }else{
                            this.itr['other_medical_intervention'] = '';
                        }
                    });
                },

                deleteConsultation1: function(consultation, event){
                    
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
                                self.$http.post('/api/consultation/delete/post', consultation ,function(data){
                                    if(data['status'] == 'success'){
                                        self.fetchUserConsultations();
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


                fetchUserConsultations: function(){
                    this.$http.get('/api/consultations/get?lastdate='+this.lastdate+'&patient_id={!! $patient->id!!}', function(data){
                        this.consultations = data['consultations'];
                        this.consultation = this.consultations[0];  
                        if(this.consultations.length <= 10 ){
                            this.showLoadMoreBtn = false;
                        }else{
                            this.showLoadMoreBtn = true;
                        }
                    });
                },
                
                loadMore: function(){
                    var lastitem = this.consultations[Object.keys(this.consultations)[Object.keys(this.consultations).length - 1]];
                    this.lastdate = lastitem.created_at;
                    self = this;
                    var l = Ladda.create(document.querySelector( '.loader' ));
                    l.start();
                    this.$http.get('/api/consultations/get?lastdate='+this.lastdate+'&patient_id={!! $patient->id!!}', function(data){
                        var consultaions = data['consultations'];
                        if(data['remaining'] == 0){
                            self.showLoadMoreBtn = false;
                        }

                        if(data['error'] == 'Unauthenticated'){
                            windows.location = 'http://hidok.com';
                        }

                        consultaions.forEach(function(consultaion , index){
                            self.consultations.push(consultaion);
                        });
                        l.stop();
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
                            },
                            noSuggestionNotice: false,
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

                            noSuggestionNotice: false,
                        });

                    });
                },

                fetchITR: function(type){

                    this.$http.get('/api/itr/get/'+this.consultation.id+'/'+type ,function(data){
                        
                        if(type == 'all'){
                            this.itr = data['itr'];
                            this.itr['present_illness_history']  =  this.itr['present_illness_history'].length > 0 ? this.itr['present_illness_history'][0].value : ''; 
                            this.itr['past_medical_history']  =  this.itr['past_medical_history'].length > 0 ? this.itr['past_medical_history'][0].value : ''; 
                            this.itr['other_medical_intervention']  =  this.itr['other_medical_intervention'].length > 0 ? this.itr['other_medical_intervention'][0].value : ''; 
                        }else{
                            this.itr[type] = data[type];
                        }
                        
                        
                        
                        /*if(type == 'diagnosis'){
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
                        }else{
                            
                        }     */
                    });
                },
 
      
            },



        };
    </script>
@endsection

