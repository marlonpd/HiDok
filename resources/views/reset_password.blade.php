@extends('layout')

@section('content')
<div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
                  <h3><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center">Forgot Password?</h2>
                  <p>You can reset your password here.</p>
                  <div class="panel-body">
                    
                    <form class="form">
                    <fieldset>
                      <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock color-blue"></i></span>
                        
                        <input id="emailInput" v-model="password" placeholder="Enter New Password" class="form-control" required="" type="password">
                      </div>
                      </div>

                      <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock color-blue"></i></span>
                        
                        <input id="emailInput" v-model="password1" placeholder="Re-enter New Password" class="form-control" required="" type="password">
                      </div>
                      </div>

                      <div class="form-group">
                       <a  @click="submitNewPassword($event)" class="btn btn-primary btn-block" id="btn-olvidado">
                Submit
                </a>
                      </div>
                    </fieldset>
                    </form>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
@endsection

@section('javascripts')
    <script>


        var childMixin = {

            mounted() {
            },

            created: function() {
            },

            data(){
                return {
                    email               : '{!! $user->email !!}',
                    reset_password_code : '{!! $user->reset_password_code !!}',
                    password1           : '',
                    password            : '',
                }
            },

            events: {

            },

            methods: {
                submitNewPassword : function(event){
                    event.preventDefault();
                    if(this.password != this.password1){
                        swal({
                            title: 'Error!',
                            text: 'Password does not match!!.',
                            timer: 1000,
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


                        return;
                    }

                    if(this.password.length < 6){
                        swal({
                            title: 'Error!',
                            text: 'Password must be atleast 6 characters!',
                            timer: 1000,
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


                        return;
                    }

                     var data = { email : this.email,
                                  password : this.password,
                                  reset_password_code : this.reset_password_code,
                       };
                    var l = Ladda.create(document.querySelector( '.btn-block' ));
                    l.start();

                    this.$http.post('/api/reset/password/post', data ,function(data){
                        if(data['status'] == 'success'){
                            swal({
                                title: 'Success!',
                                text: 'Congrats!, you successfully update your password.',
                                showConfirmButton : false,
                                timer: 1000,
                                type : 'success',
                            }).then(function () {},function (dismiss) {});
                            this.email = '';
                            window.location = "/home";
                        }else if(data['status'] == 'invalid_reset_code'){
                            swal({
                                title: 'Error!',
                                text: 'Request a new again!.',
                                timer: 1000,
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
                        }else{
                            swal({
                                title: 'Error!',
                                text: 'Please try again!.',
                                timer: 1000,
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
                        l.stop();
                    });
                },
            },




        };
    </script>
@endsection

