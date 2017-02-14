<template>
    <div class="modal" id="register" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">
      <div class="modal-dialog">
           <div class="loginmodal-container">
            <h1>You are</h1><br>
            
            <form class="form-horizontal well" role="form">
              <div class="row">
                <div class="col-xs-6">
                  <img src="http://placehold.it/160x100" class="img-responsive img-radio">
                  <a href="/patient/register/"  class="btn btn-primary col-xs-12">Patient</a>
                </div>
                <div class="col-xs-6">
                  <img src="http://placehold.it/160x100" class="img-responsive img-radio">
                  <a href="/doctor/register"  class="btn btn-primary col-xs-12">Doctor</a>
                </div>
              </div>
            </form>       

    
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
                
                user : {
                    email : null,
                    password : null,
                },

            }
        },

        events: {

        },

        methods: {
            



        },

   
    }
</script>

