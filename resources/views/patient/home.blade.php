@extends('layout')

@section('content')
<div class="container">
    <div class="col-sm-8 background-white">
            <div class="post-area">
                <div class="status-upload">
                    <form>

                       <textarea v-model="post.content" placeholder="What do you feel right now?" ></textarea>
                        <ul>
                            <li><input type="checkbox" name="private" v-model="post.public" checkv-bind:true-value="1" v-bind:false-value="0"></li> Share to doctor
                        </ul>
                        <button type="submit" @click="saveFeeling($event)" class="btn btn-success green"><i class="fa fa-share"></i> Submit</button>
                    </form>
                    

                </div><!-- Status Upload  -->

                
            </div><!-- Widget Area -->

            <div class="span8">
                
                <template v-for="feeling in feelings">
                    <div>
                        <div class="pull-right">
                            <i class="fa fa-pencil fa-1 hand-pointer" data-toggle="modal" data-target="#edit-feeling-form" @click="updateFeeling(feeling, $event)" aria-hidden="true"></i>
                            <i class="fa fa-trash fa-1 hand-pointer" @click="deleteFeeling(feeling,$event)" aria-hidden="true"></i>
                        </div>
                        <p>@{{ feeling.content }}</p>
                        <div>
                            <span class="badge badge-success">Posted @{{ feeling.created_at }}</span><div class="pull-right"><span class="label">alice</span> <span class="label">story</span> <span class="label">blog</span> <span class="label">personal</span></div>
                        </div> 
                        <hr>
                    </div>
                </template>
            </div>

            <br>
            <br>
            <div v-show="showLoadMoreBtn" class="row loadmore-container" style="text-align:center;">
                <button value="Load More" @click="loadMore()" style="width:30%;" class="btn btn-primary ladda-button loader" data-style="expand-left"><span class="ladda-label">Load More</span></button>      
            </div>
            <br>

    </div>
    <div class="col-sm-4 ">
      <!--Body content-->
      <div class="row background-white margin-left-xs">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
      </div>
    </div>  
</div>

<edit-feeling-form :feeling="selectedFeeling"></edit-feeling-form>
@endsection

@section('javascripts')
    <script>


        var childMixin = {
            mounted() {},

            created: function() {
                this.fetchFeelings();
            },

            data(){
                return {
                    post : {
                        content : '',
                        public : 1,
                    },
                    lastdate : "",
                    showLoadMoreBtn : true, 
                    feelings : {},
                    selectedFeeling : {},
                }
            },

            events: {},

            methods: {
                saveFeeling: function(event){
                    event.preventDefault();

                    if(this.post.content != ''){
                        this.$http.post( '/api/feeling/post' , this.post ,function(data){
                            if(data['status'] == 'success'){
                                this.post.content = '';
                                this.post.public = 1;
                                this.fetchFeelings();
                            }else{

                            }
                        });
                    }
                },

                fetchFeelings: function(){
                    this.$http.get('/api/feelings/get' , function(data){
                        this.feelings = data['feelings'];
                    });
                },

                updateFeeling: function(feeling){
                    this.selectedFeeling = feeling;
                },

                deleteFeeling: function(feeling, event){
                    
                    event.preventDefault();
                    var self = this; 
                    var feel = feeling;

                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(function (isConfirm, feeling) {
                            if(isConfirm){
                                self.$http.post( '/api/feeling/delete/post' , feel ,function(data){
                                    if(data['status'] == 'success'){
                                        self.feelings.$remove(feeling);
                                    }else{

                                    }
                                });
                            }
                            else
                            {
                                swal("cancelled","Your categories are safe", "error");
                            }
                    });
                },

                loadMore: function(){
                    var lastitem = this.feelings[Object.keys(this.feelings)[Object.keys(this.feelings).length - 1]];
                    this.lastdate = lastitem.created_at;
                    self = this;
                    var l = Ladda.create(document.querySelector( '.loader' ));
                    l.start();
                    this.$http.get('/api/feelings/get?lastdate='+this.lastdate, function(data){
                        var moreFeelings = data['feelings'];
                        if(data['remaining'] == 0){
                            self.showLoadMoreBtn = false;
                        }

                        if(data['error'] == 'Unauthenticated'){
                            windows.location = 'http://hidok.com';
                        }

                        moreFeelings.forEach(function(moreFeeling , index){
                            self.feelings.push(moreFeeling);
                        });
                        l.stop();
                    });
                }
            },



        };
    </script>
@endsection

