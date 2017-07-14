@extends('layout')

@section('content')
<div class="container">
    <div class="row">
    
            <div class="panel panel-default">
                <div class="panel-heading">Feedback
                <div class="pull-right">
                    <input type="text" class="form-control input-md" name="searchKey" v-model="searchKey" />
                    
                </div>
                <div class="clr"></div>
                </div>

                <div class="panel-body">
             


                   <div class="row" v-for="feedback in filterBy(feedbacks,searchKey)">
                        <div class="col-sm-2">
                        <div class="thumbnail">
                        <img class="img-responsive user-photo" :src="feedback.patient.thumbnail">
                        </div><!-- /thumbnail -->
                        </div><!-- /col-sm-1 -->

                        <div class="col-sm-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                        <a :href="'/patient/consultations/'+feedback.patient.id"><strong> @{{ feedback.patient.lastname }} , @{{ feedback.patient.firstname  }}</strong></a> 
                        <!--<span class="text-muted">commented 5 days ago</span>-->
                        </div>
                        <div class="panel-body">
                        <p>@{{ feedback.content }}</p>
                        <p>@{{ feedback.created_at }}]</p>
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

                    <br>
                    <div v-show="showLoadMoreBtn" class="row loadmore-container" style="text-align:center;">
                        <button value="Load More" @click="loadMore()" style="width:30%;" class="btn btn-primary ladda-button loader" data-style="expand-left"><span class="ladda-label">Load More</span></button>      
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
                this.fetchUserFeedbacks();
            },

            data: function(){
                return {
                    lastdate : "",
                    showLoadMoreBtn : true, 
                    searchKey : '',
                }
            },

            methods:{
                fetchUserFeedbacks: function(){
                    this.$http.get('/api/feedbacks/get?lastdate='+this.lastdate, function(data){
                        this.feedbacks = data['feedbacks'];
                    });
                },
                
                loadMore: function(){
                    var lastitem = this.feedbacks[Object.keys(this.feedbacks)[Object.keys(this.feedbacks).length - 1]];
                    this.lastdate = lastitem.created_at;
                    self = this;
                    var l = Ladda.create(document.querySelector( '.loader' ));
                    l.start();
                    this.$http.get('/api/feedbacks/get?lastdate='+this.lastdate, function(data){
                        var items = data['feedbacks'];
                        if(data['remaining'] == 0){
                            self.showLoadMoreBtn = false;
                        }else{
                            self.showLoadMoreBtn = false;
                        }

                        if(data['error'] == 'Unauthenticated'){
                            windows.location = 'http://'+this.APP_DOMAIN;
                        }

                        items.forEach(function(item , index){
                            self.feedbacks.push(item);
                        });
                        l.stop();
                    });
                }


            }

        };
    </script>
@endsection