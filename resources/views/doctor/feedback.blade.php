@extends('layout')

@section('content')
<div class="container">
    <div class="row">
    
            <div class="panel panel-default">
                <div class="panel-heading">Feedback</div>

                <div class="panel-body">
             


                   <div class="row" v-for="feedback in feedbacks">
                        <div class="col-sm-2">
                        <div class="thumbnail">
                        <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                        </div><!-- /thumbnail -->
                        </div><!-- /col-sm-1 -->

                        <div class="col-sm-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                        <strong> @{{ feedback.patient.lastname }} , @{{ feedback.patient.firstname  }}</strong> <span class="text-muted">commented 5 days ago</span>
                        </div>
                        <div class="panel-body">
                        @{{ feedback.content }}
                        </div><!-- /panel-body -->
                        </div><!-- /panel panel-default -->
                        </div><!-- /col-sm-5 -->

                        <div class="col-sm-4">
                            <div class="btn-group vcenter">
                                <a v-if="feedback.approved == 0" class="btn btn-success" @click="approveFeedback(feedback, $event)" href="#">Approve</a>
                                <a v-else class="btn btn-success disabled"  href="#">Approved</a>
                                <a class="btn btn-danger" @click="deleteFeedback(feedback,$event)" href="#">Delete</a>
                            </div>
                                
                        </div><!-- /col-sm-1 -->

                        <!-- /col-sm-5 -->
                    </div> 
                   
                </div>
            </div>

    </div>
</div>
@endsection




@section('javascripts')
    <script>
        var childMixin = {

            mounted(){
              
            },
            created: function() {
                this.fetchFeedback();
            },



            data: function(){
                return {

                }
            },

            methods:{



            }

        };
    </script>
@endsection