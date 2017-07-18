@extends('layout')

@section('content')
<div class="container">
        <div class="row">
        <div class="col-sm-4 col-sm-offset-4 background-white">
            <h4 class="">
            Haven't received any activation email?
            </h4>
            <form accept-charset="UTF-8" role="form" id="login-recordar" >
            <fieldset>
                <span class="help-block">
                Email address you use to create your account
                <br>
                We'll send you an email to activate your account and start using HiDok.
                </span>
                <div class="form-group input-group">
                <span class="input-group-addon">
                    @
                </span>
                <input class="form-control" v-model="email" placeholder="Email" name="email" type="email" required="">
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
                recoverEmail : function(event){
                    event.preventDefault();
                    var data = { email : this.email };

                    this.$http.post('/api/resend/account/activation', data ,function(data){
                        if(data['status'] == 'success'){
                            swal({
                                title: 'Success!',
                                text: 'An email has been sent to '+this.email+'. Please check to acctivate your account.',
                                showConfirmButton : false,
                                timer: 1000,
                                type : 'success',
                            }).then(function () {},function (dismiss) {});

                            this.email = '';
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
                    });
                },
            },



        };
    </script>
@endsection

