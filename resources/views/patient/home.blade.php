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
                
                <template v-for="(post, key, index)  in posts ">
                    <div class="post-detail">
                        <div class="col-md-2">
                            <div class="post-userphoto thumbnail">
                                <img :src="post.thumbnail" class="img-responsive user-photo">
                            </div>
                        </div> 

                        <div class="col-md-10">
                            <div class="row">
                                <div class="pull-left">
                                     <a v-if="post.account_type ==1 " :href="'/doctor/profile/'+post.id">
                                            @{{ post.firstname | capitalize}} @{{ post.lastname | capitalize}}
                                        </a>
                                        <a v-else :href="'/patient/consultations/'+post.id">
                                            @{{ post.firstname | capitalize}} @{{ post.lastname | capitalize}}
                                        </a>   
                                </div>

                                <div  class="pull-right">
                                     <div v-if="authUser.id == post.id" class="dropdown post-option">
                                        <button class="btn dropdown-toggle post-option-btn" type="button" data-toggle="dropdown">
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu post-option-menu">
                                            <li class="hand-pointer"  @click="updatepost(post, $event)" data-toggle="modal" data-target="#edit-post-form"  aria-hidden="true"><i class="fa fa-pencil fa-1" ></i>Edit </li>
                                            <li class="hand-pointer"   @click="deletepost(key , post , $event)"><i class="fa fa-trash fa-1 " aria-hidden="true"></i>Delete</li>
                                        </ul>
                                    </div> 

                                </div>

                            </div>
                            
                            <div class="row">
                                

                                <p>@{{ post.content | truncate(300, ' ') }}

                                <div v-show="post.content.length > 300 ">
                                    <a :href='"/post/"+post.post_id'>read more</a>
                                </div>
                                </p> 

                                <div>
                                    <span class="date">Posted @{{ post.created_at }}</span><div class="pull-right"><span class="label">alice</span> <span class="label">story</span> <span class="label">blog</span> <span class="label">personal</span></div>
                                </div> 

                            </div>
                            
                        </div>
                        <div class="clr"></div>
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
                    if(filter == 1){
                        this.showLoadMoreBtn = true;
                    }else{

                    }
                    this.fetchposts(filter);
                },

                fetchposts: function(filter){
                    this.$http.get('/api/posts/get?filter='+filter , function(data){
                        this.posts = data['posts'];
                        if(data['remaining'] > 10){
                            self.showLoadMoreBtn = true;
                        }else{
                            self.showLoadMoreBtn = false;
                            
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
                            this.showLoadMoreBtn = false;
                        }else{
                            this.showLoadMoreBtn = true;
                        }

                        if(data['error'] == 'Unauthenticated'){
                            windows.location = 'http://'+this.APP_DOMAIN;
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

