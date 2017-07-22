
window.Vue = require('vue/dist/vue.js');
//import * as Vue from 'vue/dist/vue.common.js';

window.VueRouter = require('vue-router');
//Vue.use(require('vue-resource-2'));

var VueResource = require('vue-resource-2');
Vue.use(VueResource);

import Vue2Filters from 'vue2-filters'
Vue.use(Vue2Filters);




Vue.config.debug = true; 
Vue.http.options.root = '/api';
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');


// 1. Define route components.
// These can be imported from other files
const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// Vue.extend(), or just a component options object.
// We'll talk about nested routes later.
const routes = [
  { path: '/foo', component: Foo },
  { path: '/bar', component: Bar }
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
  routes // short for routes: routes
})


var components = {};
Vue.component('create-clinic-form', require('./components/CreateClinicForm.vue'));
Vue.component('edit-clinic-form', require('./components/EditClinicForm.vue'));
Vue.component('login-form', require('./components/Login.vue'));
Vue.component('create-schedule', require('./components/CreateSchedule.vue'));
Vue.component('create-appointment-form', require('./components/CreateAppointmentForm.vue'));
Vue.component('edit-schedule', require('./components/EditSchedule.vue'));
Vue.component('register', require('./components/Register.vue'));
Vue.component('feedback', require('./components/Feedback.vue'));
Vue.component('schedule-appointment', require('./components/Appointment.vue'));
Vue.component('re-schedule', require('./components/ReSchedule.vue'));
Vue.component('patient-re-schedule', require('./components/PatientReSchedule.vue'));
Vue.component('create-feedback-form', require('./components/CreateFeedbackForm.vue'));
Vue.component('assessment-form', require('./components/AssessmentForm.vue'));
Vue.component('laboratory-form', require('./components/LaboratoryForm.vue'));
Vue.component('diagnosis-form', require('./components/DiagnosisForm.vue'));
Vue.component('treatment-form', require('./components/TreatmentForm.vue'));
Vue.component('patient-profile-form', require('./components/PatientProfileForm.vue'));
Vue.component('doctor-profile-form', require('./components/DoctorProfileForm.vue'));
Vue.component('chief-complaint-set', require('./components/itr/ChiefComplaintSet.vue'));
Vue.component('vital-signs-set', require('./components/itr/VitalSignsSet.vue'));
Vue.component('diagnosis-set', require('./components/itr/DiagnosisSet.vue'));
Vue.component('treatment-set', require('./components/itr/TreatmentSet.vue'));
Vue.component('add-symptoms-form', require('./components/itr/AddSymptomsForm.vue'));
Vue.component('add-vitalsigns-form', require('./components/itr/AddVitalSignsForm.vue'));
Vue.component('add-diagnosis-form', require('./components/itr/AddDiagnosisForm.vue'));
Vue.component('add-treatment-form', require('./components/itr/AddTreatmentForm.vue'));
Vue.component('add-laboratory-form', require('./components/itr/AddLaboratoryForm.vue'));
Vue.component('add-other-diagnostic-test-form', require('./components/itr/AddOtherDiagnosticTestForm.vue'));
Vue.component('add-general-appearances-form', require('./components/itr/AddGeneralAppearanceForm.vue'));
Vue.component('add-skins-form', require('./components/itr/AddSkinForm.vue'));
Vue.component('add-heent-form', require('./components/itr/AddHeentForm.vue'));
Vue.component('add-neck-form', require('./components/itr/AddNeckForm.vue'));
Vue.component('add-chest-and-lungs-form', require('./components/itr/AddChestAndLungsForm.vue'));
Vue.component('add-cardiovascular-system-form', require('./components/itr/AddCardiovascularSystemForm.vue'));
Vue.component('add-abdomen-form', require('./components/itr/AddAbdomenForm.vue'));
Vue.component('add-genito-urinary-system-form', require('./components/itr/AddGenitoUrinarySystemForm.vue'));
Vue.component('add-extremity-form', require('./components/itr/AddExtremityForm.vue'));
Vue.component('edit-post-form', require('./components/EditPostForm.vue'));


Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('MMM DD, YYYY hh:mm a');
  }
});

const app = new Vue({
  router,
  el: '#app',

  mixins : [main,childMixin],

  data : function(){
    return {
      schedules : {},
      editSchedule : {},
      feedbacks : {},
      clinics : {},
      constants : {},
      authUser : {},   
      appointmentITR : {},
      userPatients : {},
      userDoctors : {},
      defaultPhoto : '',
      searchKey : '',
      unReadNotificationCount : 0,
    }
  },

  created: function(){
  },

  mounted: function(){
  },


  methods:{
    reSchedAppointments : function(appointmentId, clinicId){
        self = this;
        this.appointments.forEach(function(appointment , index){
          if(appointment['id'] == appointmentId){
            appointment['confirm'] = 1;
            appointment['re_schedule_by_id'] = self.authUser.id;
            return false;
          }
        });
    },

    fetchClinics : function(id){
      this.$http.get('/api/clinics/get/'+id, function(data){
        this.clinics = data['clinics'];
      });
    },

    fetchSchedules : function(id){
      this.$http.get('/api/schedules/get/'+id, function(data){
        this.schedules = data['schedules'];
      });
    },

    editScheduleShow : function(schedule){
      this.editSchedule = schedule;
    },

    deleteSchedule : function(schedule){
       var self = this; 
       var sched = schedule;

        swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }
        ).then(function (isConfirm,schedule) {

          if(isConfirm){
            self.$http.post('/api/schedule/delete/post', sched.id, function(data){
              if(data == "success"){
                swal('Deleted!','Your file has been deleted.','success');
                self.fetchSchedules();
              }
            });
          }
          else
          {
              swal("cancelled","Your categories are safe", "error");
          }

          
        });

    },

    fetchFeedback: function(){
      this.$http.get('/api/feedbacks/get/', function(data){
        this.feedbacks = data['feedbacks'];  
      });
    },

    fetchApprovedFeedback: function(doctor_id){
      this.$http.get('/api/feedback/approved/get/'+doctor_id, function(data){
        this.feedbacks = data['feedbacks'];  
      });
    },

    approveFeedback: function(feedback ,event){
      event.preventDefault();
      this.$http.post('/api/feedback/approved/post', feedback, function(data){
        if(data == 'success'){
          feedback.approved = 1;
        }else{
          swal("Error","Please try again!", "error");
        }
      });
    },

    deleteFeedback: function(feedback,event){
      event.preventDefault();
      this.$http.post('/api/feedback/delete/post', feedback, function(data){
        if(data == 'success'){
          this.fetchFeedback();
        }else{
          swal("Error","Please try again!", "error");
        }
      });
    },

   fetchAllAppointments: function(){
        this.$http.get('/api/auth/appointment/all/get', function(data){
            this.appointments = data['appointments'];
        });
    },

    fetchAppointment : function(){
      this.$http.get('/api/appointments/get?lastdate='+this.lastdate, function(data){
          this.appointments = data['appointments'];
      });
    },

    deleteAppointment: function(appointment,event){
      event.preventDefault();
      this.$http.post('/api/appointment/delete/post', appointment, function(data){
        if(data == 'success'){
          this.fetchAppointment();
        }else{
          swal("Error","Please try again!", "error");
        }
      });
    },

    fetchConstants: function(){
      var keys= 'path=1&images=1&account_type=1&account_type_label=1&account_type_rev=1&gender=1&religion=1&specialization=1&appointment_status=1';
      this.$http.get('/api/constants/get?'+keys, function(data){
        this.constants = data['constants'];
        this.defaultPhoto = this.constants['images']['default_photo'];
      });
    },

    isValidEmailAddress: function(emailAddress){
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    },

  },
});


socket.on("notification-channel:App\\Events\\NotifyUser", function(message){
      var thumbnail = message.data['thumbnail'];
      var name = message.data['name'];
      var action = message.data['action'];
      var url = message.data['url'];
      var created_at = message.data['created_at'].date;
      //this.unReadNotification.push(message.data['notification']);
      var recepient_id = message.data['recepient_id'];

      if(recepient_id == app.authUser.id ){

          app.fetchUnReadNotifications();
          new Noty({
            type: 'success',
            layout: 'topRight',
            theme: 'mint',
            text: '<a href="'+url+'"><div class="col-sm-3 padding-lr-0 paddint-top-0">'+
            '<div class="thumbnail"><img src="'+thumbnail+'" class="img-responsive user-photo"></div>'+
            '</div> '+
            '<div class="col-sm-9"> '+
              '<div class="pull-left">'+
                ' <span class="white">From: <b>'+name+'</b></span><br>'+
                ' <span class="white"><b>'+action+'</b></span>'+
                ' <span class="date white row">Posted : '+created_at+'</span>'+
              '</div><div class="clr"></div>'+
            '</div>'+
            '</a>',
            timeout: 50000,
            progressBar: true,
            closeWith: ['click', 'button'],
            animation: {
              open: 'noty_effects_open',
              close: 'noty_effects_close'
            },
            id: false,
            force: false,
            killer: false,
            queue: 'global',
            container: false,
            buttons: [],
            sounds: {
              sources: [],
              volume: 1,
              conditions: []
            },
            titleCount: {
              conditions: []
            },
            modal: false
          }).show();
      }
});