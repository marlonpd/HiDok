<template>

    <div class="modal" id="create" tabindex="-1" role="dialog" aria-labelledby="create" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Create New Schedule</h4>
      </div>
          <div class="modal-body">
         
    <form class="form-horizontal">

        <div class="form-group">
            <label class="control-label col-xs-3">Day available:</label>
            <div class="col-xs-3">
                <select class="form-control" v-model="schedule.from_day">
                    <option>Sunday</option>
                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                    <option>Thursday</option>
                    <option>Friday</option>
                    <option>Saturday</option>
                </select>

                
            </div>
            <div class="col-xs-1">
            to
            </div>
            <div class="col-xs-3">
                <select class="form-control" v-model="schedule.to_day">
                    <option>Sunday</option>
                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                    <option>Thursday</option>
                    <option>Friday</option>
                    <option>Saturday</option>
                </select>
            </div>

        </div>



          <div class="form-group">
            <label class="control-label col-xs-3">Time available:</label>
            <div class="col-xs-3">
                <select class="form-control" v-model="schedule.from_time">
                    <option>1:00 a.m.</option>
                    <option>2:00 a.m.</option>
                    <option>3:00 a.m.</option>
                    <option>4:00 a.m.</option>
                    <option>5:00 a.m.</option>
                    <option>6:00 a.m.</option>
                    <option>7:00 a.m.</option>
                    <option>8:00 a.m.</option>
                    <option>9:00 a.m.</option>
                    <option>10:00 a.m.</option>
                    <option>11:00 a.m.</option>
                    <option>12:00 a.m.</option>
                    <option>1:00 p.m.</option>
                    <option>2:00 p.m.</option>
                    <option>3:00 p.m.</option>
                    <option>4:00 p.m.</option>
                    <option>5:00 p.m.</option>
                    <option>6:00 p.m.</option>
                    <option>7:00 p.m.</option>
                    <option>8:00 p.m.</option>
                    <option>9:00 p.m.</option>
                    <option>10:00 p.m.</option>
                    <option>11:00 p.m.</option>
                    <option>12:00 p.m.</option>
                </select>
            </div>
            <div class="col-xs-1">to</div>
            <div class="col-xs-3">
                <select class="form-control" v-model="schedule.to_time">
                    <option>1:00 a.m.</option>
                    <option>2:00 a.m.</option>
                    <option>3:00 a.m.</option>
                    <option>4:00 a.m.</option>
                    <option>5:00 a.m.</option>
                    <option>6:00 a.m.</option>
                    <option>7:00 a.m.</option>
                    <option>8:00 a.m.</option>
                    <option>9:00 a.m.</option>
                    <option>10:00 a.m.</option>
                    <option>11:00 a.m.</option>
                    <option>12:00 a.m.</option>
                    <option>1:00 p.m.</option>
                    <option>2:00 p.m.</option>
                    <option>3:00 p.m.</option>
                    <option>4:00 p.m.</option>
                    <option>5:00 p.m.</option>
                    <option>6:00 p.m.</option>
                    <option>7:00 p.m.</option>
                    <option>8:00 p.m.</option>
                    <option>9:00 p.m.</option>
                    <option>10:00 p.m.</option>
                    <option>11:00 p.m.</option>
                    <option>12:00 p.m.</option>
                </select>
            </div>

        </div>



            <div class="form-group">
            <label class="control-label col-xs-3" for="phoneNumber">Address:</label>
            <div class="col-xs-9">
                <input class="form-control" id="phoneNumber" v-model="schedule.address" placeholder="Address" type="tel">
            </div>
          </div>


          <div class="form-group">
            <div class="col-xs-offset-3 col-xs-9">
                <label class="checkbox-inline">
                    <input value="news" type="checkbox" v-model="schedule.default_address"> Set as default schedule.
                </label>
            </div>
        </div>
 

    </form>

          </div>
          <div class="modal-footer ">
        <button type="button" @click="createSchedule($event)" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Create</button>
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

        },

        created: function() {
            window.componentInstance = this;
        },


        props : ['schedules', 'id'],

        data(){
            return {

                schedule: {
                  from_time : null,
                  to_time : null,
                  from_day : null, 
                  to_day : null,
                  address : null,
                  default_address : false,
                }
            }
        },

        events: {

        },

        methods: {
          createSchedule: function(event){
            event.preventDefault();

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

            this.$http.post('/api/schedule/create/post', this.schedule, function(data){
              if(data == 'success'){
                $('#create').modal('hide');
              
               // this.$parent.$options.methods.fetchSchedules(0);

                swal({
                  title: 'Success!',
                  text: 'Successfully created new schedule.',
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
