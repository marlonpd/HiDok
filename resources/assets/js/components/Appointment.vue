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
				  <button  v-else type="button" class="btn btn-primary btn-success disabled" >Confirmed</button>		  				  

				  <button type="button" class="btn btn-primary btn-infor"  data-title="Re-Schedule" data-toggle="modal" data-target="#reschedule">Re-Schedule</button>
				  <button type="button" class="btn btn-primary btn-danger" @click="deleteAppointment(appointment, $event)">Delete</button>
				</div>     
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
        	this.fetchScheduleAppointment(this.schedule_id);
        },


        props : ['schedule_id'],

        data(){
            return {
            	appointments : {}
            }
        },

        events: {

        },

        methods: {
        	fetchScheduleAppointment : function(schedule_id){
		      this.$http.get('/api/auth/schedule/appointment/get/'+schedule_id, function(data){
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

		                this.fetchScheduleAppointment(thisAppointment.id);
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