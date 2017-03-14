<template>

    <div class="modal" id="reschedule" tabindex="-1" role="dialog" aria-labelledby="reschedule" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Re schedule an appointments  </h4>
      </div>
          <div class="modal-body">

            <div class="form-group">

                  Set new schedule date
                  <div class='input-group date' >
                      <input type='text' id="appointment_date" v-model="appointment.appointment_date" class="form-control" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>

                  Note
                  <div class="input-group col-md-12">
                     <textarea placeholder="Add some note" v-model="appointment.note" width="100%" class="col-md-12" ></textarea>  
                  </div><!-- Widget Area -->

              </div>
 
          </div>
          <div class="modal-footer ">
        <button type="button" @click="submitNewSchedule()" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Re-Schedule</button>
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


        props : ['appointment' , 'userId'],

        data(){
            return {
 
            }
        },

        events: {

        },

        methods: {


  		    reschedAppointment : function(appointment, event){
  		    	event.preventDefault();
  		    	this.appointment.appointment_date = $("#appointment_date").val();
  		    },


          submitNewSchedule : function(){
              self = this;
              this.$http.post('/api/appointment/reschedule/post', this.appointment, function(data){
                      
                      if(data['status'] == "success"){
                            this.appointment =data['appointment'];
                            swal({
                              title: 'Success!',
                              text: 'Successfully updated your schedule.',
                              showConfirmButton : false,
                              timer: 1000,
                              type : 'success',
                            }).then(
                              function () {},
                              function (dismiss) { 
                                $('#reschedule').modal('hide');
                              }
                            );

                            this.$parent.reSchedAppointments(this.appointment.id,this.appointment.clinic_id);
                        }else{

                             swal({
                                title: 'Error!',
                                text: 'Unable to submit your new schedule, please try again!',
                                timer: 1000,
                                type : 'error',
                                showConfirmButton : false,
                              }).then( function () {}, function (dismiss) {});

                        }


              });

     
          }

	
  
        },

   
    }
</script>

<style>

</style>