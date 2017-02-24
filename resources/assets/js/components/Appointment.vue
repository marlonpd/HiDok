<template>
	<div>
		 <div class="row" v-for="appointment in appointments">
	        <div class="col-sm-2">
	        	<div class="thumbnail">
	        		<img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
	        	</div><!-- /thumbnail -->
	        </div><!-- /col-sm-1 -->

	        <div class="col-sm-4">
		        <div class="panel panel-default">
		        <div class="panel-heading">
			        <strong> {{ appointment.patient.lastname }} , {{ appointment.patient.firstname  }}</strong> 
			        <span class="text-muted">requested 5 days ago</span>
		        </div>
		        <div class="panel-body">
		       	 {{ appointment.appointment_date }}
		        </div><!-- /panel-body -->
		        </div><!-- /panel panel-default -->
	        </div><!-- /col-sm-5 -->

	        <div class="col-sm-6">
	             <div class="btn-group vcenter">
				 
				  <button  v-if="appointment.confirmed == 0" type="button" class="btn btn-primary btn-success" @click="confirmAppointment(appointment, $event)">Confirm</button>
					  				  
				  <button  v-if="appointment.confirmed == 1" type="button" class="btn btn-primary btn-success" @click="consult(appointment)">Consult</button>
				  <button  v-if="appointment.confirmed == 2" type="button" class="btn btn-primary btn-success disabled" >Consult</button>
				  <button type="button" class="btn btn-primary btn-infor"  data-title="Re-Schedule" data-toggle="modal" data-target="#reschedule" @click="setAppointmentChild(appointment)">Re-Schedule</button>
				  <button type="button" class="btn btn-primary btn-danger" @click="deleteAppointment(appointment, $event)">Delete</button>
				</div>   

				<a @click="viewITR(appointment)">(view itr)</a>   
	        </div><!-- /col-sm-1 -->

	        <!-- /col-sm-5 -->
	    </div> 
    </div>
</template>

<script>

    export default {
        mounted() {

        },

        created: function() {
        	//this.fetchScheduleAppointment(this.schedule_id);
        },


        props : ['appointments', 'clinic_id'],

        data(){
            return {
            	
            }
        },

        events: {

        },

        methods: {
        	viewITR : function(appointment){
        		window.location = "/patient/itr/"+appointment.patient_id;
        	},

    	    setAppointmentChild: function(appointment){
    	    	//this.$parent.$options.methods.setAppointmentMain(appointment);
    	    	//this.$parent.$options.data().editAppointment = appointment;
    	    	this.$data.editAppointment = appointment;
    	    	//alert(this.$data.editAppointment.id);

    	    	    	    	//this.$parent.$options.data().testval = 999;
               // alert('test'+this.$parent.$options.data().testval);
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
		        }
		        ).then(function (isConfirm,appointment) {

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

   
    }
</script>

<style>
	.ui-accordion-content{
		height: 300px!important;
	}
</style>