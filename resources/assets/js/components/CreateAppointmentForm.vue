<template>

    <div class="modal" id="create-appointment-form" tabindex="-1" role="dialog" aria-labelledby="create-appointment-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Request an appointment</h4>
      </div>
          <div class="modal-body">
         
              <div class="form-group">
                Select Clinic
                <div class="schedule-list">
                    <div class="radio" v-for="clinic in clinics">
                      <label><input type="radio" value="0" name="optradio" @click="setClinic(clinic.id)"> Clinic : {{ clinic.name }} , Address : {{ clinic.address }}
                      <br> 
                      <ul class="no-bullet" >
                        <li style="float:left;" v-if="clinic.open_sunday == 1"> Sunday</li>
                        <li style="float:left;" v-if="clinic.open_monday == 1">, Monday</li>
                        <li style="float:left;" v-if="clinic.open_tuesday == 1">,Tuesday</li>
                        <li style="float:left;" v-if="clinic.open_wednesday == 1">,Wednesday</li>
                        <li style="float:left;" v-if="clinic.open_thursday == 1">,Thursday</li>
                        <li style="float:left;" v-if="clinic.open_friday == 1">,Friday</li>
                        <li style="float:left;" v-if="clinic.open_saturday == 1">Saturday</li>
                        <li style="float:left;" > {{ clinic.from_day }}-{{ clinic.to_day }} {{ clinic.from_time }}-{{ clinic.to_time }} </li>
                      </ul>


                       </label>
                    </div>
                </div>
              </div>

              <div class="form-group">
                  Set exact date
                  <div class='input-group date' >
                      <input type='text' id='appointment_date' v-model="appointment.appointment_date" v-on:change="setExactDate($event)" class="form-control" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
              </div>


            
          </div>
          <div class="modal-footer ">
        <button type="button" @click="createAppointment($event)" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Request</button>
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

        props: ['clinics', 'doctor_id'],

        created: function() {

        },

        data(){
            return {
                selectedSchedule : null,
                appointment :{
                  appointment_date :  null,
                  patient_id : null,
                  doctor_id : null,
                  clinic_id : null,
                }
            }
        },

        events: {

        },

        methods: {
          setClinic: function(id){

            this.appointment.clinic_id = id;
            this.appointment.doctor_id = this.doctor_id;

          },

          setExactDate: function(event){
            alert(event.value);
          },

          createAppointment: function(event){
            event.preventDefault();
            this.appointment.appointment_date = $("#appointment_date").val();
            
            swal({
              text: 'Creating....',
              timer: 1000,
              showConfirmButton : false,
              type : 'info',
            }).then(
              function () {},
              function (dismiss) {
              }
            )

            this.$http.post('/api/appointment/request/post', this.appointment, function(data){
              if(data == 'success'){
                $('#create-appointment-form').modal('hide');
                
                swal({
                  title: 'Success!',
                  text: 'Successfully requested new appointment.',
                  showConfirmButton : false,
                  timer: 1000,
                  type : 'success',
                }).then(
                  function () {},
                  function (dismiss) {
                    if (dismiss === 'timer') {
                      console.log('I was closed by the timer')
                    }
                  }
                );

                        
              }else{
                  
                  swal({
                    title: 'Error!',
                    text: 'Unable to save please try again!',
                    timer: 1000,
                    type : 'error',
                    showConfirmButton : false,
                  }).then(
                    function () {},
                    function (dismiss) {
                      if (dismiss === 'timer') {
                        console.log('I was closed by the timer')
                      }
                    }
                  )
                  
              }

            });

          }  
  
        },

   
    }
</script>


<style>
  .schedule-list {
      height: 100px;
      overflow-y: scroll;
  }
</style>