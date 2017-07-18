<template>
    <div class="modal" id="login" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true">
      <div class="modal-dialog">
           <div class="loginmodal-container">
                    <h1>Login to Your Account</h1><br>
                  <form>
                    <input type="text" name="email" v-model="user.email" placeholder="Email">
                    <input type="password" name="password" v-model="user.password" placeholder="Password">
                  

                    <button value="Login" @click="login($event)" style="width:100%;" name="login" class="login loginmodal-submit btn btn-primary ladda-button" data-style="expand-left"><span class="ladda-label">Login</span></button>
                  </form>
                    
                  <div class="login-help">
                     <a href="/account/forgot">Forgot Password</a>
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
                
                user : {
                    email : null,
                    password : null,
                },

            }
        },

        events: {

        },

        methods: {
            login : function(event){
                
                event.preventDefault();

                var l = Ladda.create(document.querySelector( '.login' ));
                l.start();

                this.$http.post('/api/login/post', this.user, function(data){

                    l.stop();
                    
                    if(data == 'success'){
                        swal({
                          title: 'Success!',
                          text: 'Redirecting.',
                          showConfirmButton : false,
                          timer: 1000,
                          type : 'success',
                        }).then(function () {},function (dismiss) {});

                        window.location = "/home";    
                        
                    }else if(data == "error"){
                        
                        swal({
                          title: 'Error!',
                          text: 'Wrong username or password .',
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
                        );
                        
                    }else{
                        swal({
                          title: 'Error!',
                          html: 'Your account needs to be activated please check your email!. Click <a href="/account/resend/activation">here</a> to resend activation code to your email.',
                          type : 'error',
                          showConfirmButton : true,
                        }).then(
                          function () {},
                          function (dismiss) {
                            if (dismiss === 'timer') {
                              console.log('I was closed by the timer')
                            }
                          }
                        );

                    }

                });
            },


        },

   
    }
</script>
