<template>

    <div class="modal" id="edit-clinic-form" tabindex="-1" role="dialog" aria-labelledby="edit-clinic-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Edit Clinic</h4>
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
                
                <ul class="no-bullet list-inline">
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
                    <input value="news" type="checkbox" v-bind:true-value="1" v-bind:false-value="0" v-model="clinic.default_address"> Set as default clinic.
                </label>
            </div>
        </div>


        <div class="form-group">
          <div id="google_map2" style="width: 95%; height: 400px; margin:auto;margin-bottom: 10px"></div>

          <div class="col-xs-6">
            <input class="form-control" v-model="clinic.gmap_lat" id="gmap_lat2" placeholder="Latitude" type="tel">
          </div>
          
          <div class="col-xs-6">
            <input class="form-control" v-model="clinic.gmap_lng" id="gmap_lng2" placeholder="Longitude" type="tel">
          </div> 
        </div>
 
    </form>

          </div>
          <div class="modal-footer ">
        <button type="button" @click="createClinic($event)" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Update</button>
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

        props: ['clinic','doctor_id'],

        data(){
            return {


            }
        },

        mounted(){
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
            this.clinic.gmap_lat = document.getElementById('gmap_lat2').value;
            this.clinic.gmap_lng = document.getElementById('gmap_lng2').value;

            this.$http.post('/api/clinic/update/post', this.clinic, function(data){
              if(data == 'success'){
                $('#edit-clinic-form').modal('hide');
                this.$parent.fetchClinics(this.doctor_id);
                swal({
                  title: 'Success!',
                  text: 'Successfully updated '+this.clinic.name,
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
