@extends('layout')

@section('content')
<div class="container">
        <div class="row">
        <div class="col-sm-4 col-sm-offset-4 background-white">
            <h4 class="">
            Forgot your password?
            </h4>
            <form accept-charset="UTF-8" role="form" id="login-recordar" method="post">
            <fieldset>
                <span class="help-block">
                Email address you use to log in to your account
                <br>
                We'll send you an email with instructions to choose a new password.
                </span>
                <div class="form-group input-group">
                <span class="input-group-addon">
                    @
                </span>
                <input class="form-control" placeholder="Email" v-model="email" name="email" type="email" required="">
                </div>
                <a  @click="recoverEmail($event)" class="btn btn-primary btn-block" id="btn-olvidado">
                Submit
                </a>
                <p class="help-block">
                </p>
            </fieldset>
            </form>
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
                    email : '',
                }
            },

            events: {

            },

            methods: {
                recoverEmail: function(event){
                    event.preventDefault();

                    if( !this.isValidEmailAddress(this.email) ) { 
                        swal({
                            title: 'Error!',
                            text: 'Invalid email format, please check',
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

                    var data = {email : this.email};
                    var l = Ladda.create(document.querySelector( '.btn-block' ));
                    l.start();
                    this.$http.post('/api/send/password/reset/email/post', data , function(data){
                        if(data['status'] == 'success'){
                           swal({
                                title: 'Success!',
                                text: 'An email has been sent to '+this.email+'. Please check to reset your password.',
                                showConfirmButton : false,
                                timer: 1000,
                                type : 'success',
                            }).then(function () {},function (dismiss) {});     
                            this.email = '';
                        }else if(data['status'] == 'email_not_registered'){
                            swal({
                                title: 'Error!',
                                text: 'Email is not registered.',
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

                }
            },



        };
    </script>
@endsection

