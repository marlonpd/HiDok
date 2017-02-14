<template>

    <div class="modal" id="patient-reschedule" tabindex="-1" role="dialog" aria-labelledby="patient-reschedule" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Re schedule an appointment</h4>
      </div>
          <div class="modal-body">
         
          		


          	<div class="form-group">


                  Set new schedule date
                  <div class='input-group date' >
                      <input type='text' id='appointment_date' class="form-control" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>


              </div>


            
          </div>
          <div class="modal-footer ">
        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Re-Schedule</button>
      </div>
        </div>

        
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
</div>
    
</template>

<script>

    export default {
        mounted() {
          $(function () {
              $('#appointment_date').datetimepicker();
          });

        },

        created: function() {
        	
        },


        props : ['appointment'],

        data(){
            return {
        		appointment :{
                  appointment_date :  null,
                  patient_id : null,
                  doctor_id : null,
                  schedule_id : null,
                  note : null,
                }
            }
        },

        events: {

        },

        methods: {


		    reschedAppointment : function(appointment, event){
		    	event.preventDefault();
		    	this.appointment.appointment_date = $("#appointment_date").val();


		    },

	
  
        },

   
    }
</script>

<style>

</style>