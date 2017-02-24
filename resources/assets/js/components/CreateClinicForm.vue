<template>

    <div class="modal" id="create-clinic-form" tabindex="-1" role="dialog" aria-labelledby="create-clinic-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Create New Clinic</h4>
      </div>
          <div class="modal-body">
         
    <form class="form-horizontal">


        <div class="form-group">
            <label class="control-label col-xs-3" for="name">Name:</label>
            <div class="col-xs-9">
                <input class="form-control" id="name" v-model="clinic.name" placeholder="Name" type="text">
            </div>
        </div>



        <div class="form-group">
            <label class="control-label col-xs-3">Day(s) available:</label>
            <div class="col-xs-6">
                
                <ul class="no-bullet">
                  <li>
                    <input type="checkbox"  v-model="clinic.open_sunday"  v-bind:true-value="1" v-bind:false-value="0" > Sunday
                  </li>
                  <li>
                    <input type="checkbox"  v-model="clinic.open_monday"  v-bind:true-value="1" v-bind:false-value="0" > Monday
                  </li>
                  <li>
                    <input type="checkbox"  v-model="clinic.open_tuesday"  v-bind:true-value="1" v-bind:false-value="0" > Tuesday
                  </li>
                  <li>
                    <input type="checkbox"  v-model="clinic.open_wednesday"  v-bind:true-value="1" v-bind:false-value="0" > Wednesday
                  </li>
                  <li>
                    <input type="checkbox"  v-model="clinic.open_thursday"  v-bind:true-value="1" v-bind:false-value="0" > Thursday
                  </li>
                  <li>
                    <input type="checkbox"  v-model="clinic.open_friday"  v-bind:true-value="1" v-bind:false-value="0" > Friday
                  </li>
                  <li>
                    <input type="checkbox"  v-model="clinic.open_saturday"  v-bind:true-value="1" v-bind:false-value="0" > Saturday
                  </li>
                </ul>

                
            </div>
         
     
        </div>



          <div class="form-group">
            <label class="control-label col-xs-3">Time available:</label>
            <div class="col-xs-3">
                <select class="form-control" v-model="clinic.from_time">
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
                <select class="form-control" v-model="clinic.to_time">
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
                <input class="form-control" id="phoneNumber" v-model="clinic.address" placeholder="Address" type="tel">
            </div>
          </div>


          <div class="form-group">
            <div class="col-xs-offset-3 col-xs-9">
                <label class="checkbox-inline">
                    <input value="news" type="checkbox" v-model="clinic.default_address"> Set as default clinic.
                </label>
            </div>
        </div>
 

    </form>

          </div>
          <div class="modal-footer ">
        <button type="button" @click="createClinic($event)" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Create</button>
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
        },



        data(){
            return {

                clinic: {
                  name : null,
                  to_time : null,
                  from_time : null, 
                  open_sunday : 0,
                  open_monday : 0,
                  open_tuesday : 0,
                  open_wednesday : 0,
                  open_thursday : 0,
                  open_friday : 0,
                  open_saturday : 0,
                  address : null,
                  gmap_lat : null,
                  gmap_lng : null,
                  default_address : false,
                }
            }
        },

        events: {

        },

        methods: {
          createClinic: function(event){
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

            this.$http.post('/api/clinic/create/post', this.clinic, function(data){
              if(data == 'success'){
                $('#create-clinic-form').modal('hide');
              

                swal({
                  title: 'Success!',
                  text: 'Successfully created new clinic.',
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
