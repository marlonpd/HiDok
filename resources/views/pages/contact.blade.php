@extends('layout')

@section('css')
<style>
.jumbotron {
background: #358CCE;
color: #FFF;
border-radius: 0px;
}
.jumbotron-sm { padding-top: 24px;
padding-bottom: 24px; }
.jumbotron small {
color: #FFF;
}
.h1 small {
font-size: 24px;
}
</style>
@endsection

@section('content')
<div class="container background-white">
    <br>
    <div class="jumbotron jumbotron-sm">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <h1 class="h1">
                        Contact us <small>Feel free to contact us</small></h1>
                </div>
            </div>
        </div>
    </div>

 
    <div class="row">
        <div class="col-md-8">
            <div class="well well-sm">
                <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">
                                Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name" v-model="inquiry.name" required="required" />
                        </div>
                        <div class="form-group">
                            <label for="email">
                                Email Address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                <input type="email" class="form-control" id="email" v-model="inquiry.email" placeholder="Enter email" required="required" /></div>
                        </div>
                        <div class="form-group">
                            <label for="subject">
                                Subject</label>
                            <select id="subject" v-model="inquiry.subject" class="form-control" required="required">
                                <option value="na" selected="">Choose One:</option>
                                <option value="service">General Customer Service</option>
                                <option value="suggestions">Suggestions</option>
                                <option value="product">Product Support</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">
                                Message</label>
                            <textarea v-model="inquiry.message" id="message" class="form-control" rows="9" cols="25" required="required"
                                placeholder="Message"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button @click="sendMessage($event)" type="submit" class="btn btn-primary loading pull-right" id="btnContactUs">
                            Send Message</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <form>
            <legend><span class="glyphicon glyphicon-globe"></span> Our office</legend>
            <address>
                <strong>HiDok.</strong><br>
                Ponciano St.,<br>
                Davao City<br>
                <abbr title="Phone">
                    P:</abbr>
                09095776164
            </address>
            <address>
                <strong>Email</strong><br>
                <a href="mailto:#">hidokinc@gmail.com</a>
            </address>
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
                    inquiry : {
                        name : '',
                        message : '',
                        subject : '',
                        email : '',
                    }
                }
            },

            events: {

            },

            methods: {
                sendMessage: function(event){
                    event.preventDefault();
                    var l = Ladda.create(document.querySelector( '.loading' ));
                    l.start();

                    if(this.inquiry.name != '' && this.inquiry.message != '' && this.inquiry.subject != '' && this.inquiry.email != ''){
                        this.$http.post('/contact/send/message',this.inquiry,function(data){
                            if(data['status'] == 'success'){
                                swal({
                                title: 'Success!',
                                text: 'Message sent!',
                                showConfirmButton : false,
                                timer: 500,
                                type : 'success',
                            }).then(function () {},function (dismiss) {});

                            this.inquiry.name = '';
                            this.inquiry.message ='';
                            this.inquiry.subject = '';  
                            this.inquiry.email = '';
                            l.stop();

                            }else{
                                 swal("Error","Please try again!", "error");
                            }
                        });
                    }else{
                        swal("Error","All fields are required!", "error");
                    }
                }
            },



        };
    </script>
@endsection

