window.Vue = require('vue/dist/vue.js');
//import * as Vue from 'vue/dist/vue.common.js';

window.VueRouter = require('vue-router');
//Vue.use(require('vue-resource-2'));

var VueResource = require('vue-resource-2');
Vue.use(VueResource);

var VueSelect2 = require('vue2-select2');
Vue.use(VueSelect2);

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
      
    }
  },

  created: function(){

  },

  mounted: function(){

  },

  methods:{

  

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
                swal(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                );

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


    fetchAppointment : function(){
      this.$http.get('/api/auth/appointment/get', function(data){
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
      var keys= 'account_type=1&account_type_label=1&account_type_rev=1&gender=1&religion=1&specialization=1&appointment_status=1';

      this.$http.get('/api/constants/get?'+keys, function(data){
        this.constants = data['constants'];
      });

    },

  },
});


