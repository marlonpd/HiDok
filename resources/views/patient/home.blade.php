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
                        <button type="submit" @click="savepost($event)" class="btn btn-success green"><i class="fa fa-share"></i> Submit</button>
                    </form>
                    

                </div><!-- Status Upload  -->

                
            </div><!-- Widget Area -->

            <div class="clr"></div>
            <div class="section" v-show="posts.length == 0 ">
                <h2>Nothing to show</h2>
            </div>

            <div class="span8">
                <div>
                    <span class="breadcrum"><a href="#" @click="filterposts(0,$event)">All</a><span class="separator">|</span><a href="#" @click="filterposts(1,$event)">My Post</a></span>
                </div>
                
                <template v-for="(post, key, index)  in posts">
                    <div>
                        <div class="pull-right">
                            <i class="fa fa-pencil fa-1 hand-pointer" data-toggle="modal" data-target="#edit-post-form" @click="updatepost(post, $event)" aria-hidden="true"></i>
                            <i class="fa fa-trash fa-1 hand-pointer"   @click="deletepost(key , post , $event)" aria-hidden="true"></i>
                        </div>
                        <p>@{{ post.content }}</p>
                        <div>
                            <span class="badge badge-success">Posted @{{ post.created_at }}</span><div class="pull-right"><span class="label">alice</span> <span class="label">story</span> <span class="label">blog</span> <span class="label">personal</span></div>
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

<edit-post-form :post="selectedpost"></edit-post-form>
@endsection

@section('javascripts')
    <script>


        var childMixin = {
            mounted() {},

            created: function() {
                this.fetchposts(0);
            },

            data(){
                return {
                    post : {
                        content : '',
                        public : 1,
                    },
                    lastdate : "",
                    showLoadMoreBtn : true, 
                    posts : {},
                    selectedpost : {},
                }
            },

            events: {},

            methods: {
                savepost: function(event){
                    event.preventDefault();

                    if(this.post.content != ''){
                        this.$http.post( '/api/post/post' , this.post ,function(data){
                            if(data['status'] == 'success'){
                                this.post.content = '';
                                this.post.public = 1;
                                this.fetchposts(0);
                            }else{

                            }
                        });
                    }
                },

                filterposts: function(filter,event){
                    event.preventDefault();
                    this.fetchposts(filter);
                },

                fetchposts: function(filter){
                    this.$http.get('/api/posts/get?filter='+filter , function(data){
                        this.posts = data['posts'];
                        if(data['remaining'] > 10){
                            self.showLoadMoreBtn = true;
                        }
                    });
                },

                updatepost: function(post){
                    this.selectedpost = post;
                },

                deletepost: function(index , post, event){
                    event.preventDefault();
                    var self = this; 
                    var feel = post;

                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(function (isConfirm, post) {
                            if(isConfirm){
                                self.$http.post( '/api/post/delete/post' , feel ,function(data){
                                    if(data['status'] == 'success'){
                                      self.posts.splice(index, 1);
                                    }else{
                                        swal("error","Please try again!", "error");
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
                    var lastitem = this.posts[Object.keys(this.posts)[Object.keys(this.posts).length - 1]];
                    this.lastdate = lastitem.created_at;
                    self = this;
                    var l = Ladda.create(document.querySelector( '.loader' ));
                    l.start();
                    this.$http.get('/api/posts/get?lastdate='+this.lastdate, function(data){
                        var moreposts = data['posts'];
                        if(data['remaining'] == 0){
                            self.showLoadMoreBtn = false;
                        }

                        if(data['error'] == 'Unauthenticated'){
                            windows.location = 'http://hidok.com';
                        }

                        moreposts.forEach(function(morepost , index){
                            self.posts.push(morepost);
                        });
                        l.stop();
                    });
                }
            },



        };
    </script>
@endsection

