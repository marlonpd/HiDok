@extends('layout')

@section('content')
<div class="container">

        <div class="panel panel-default">
        <div class="panel-heading">Doctors</div>

        <div class="panel-body">



        <div class="row">
        <div class="col-md-4" v-for="doctor in userDoctors">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img v-if="doctor.doctor.thumbnail != ''" :src="doctor.doctor.thumbnail" class="img-responsive user-photo">
                            <div v-else>
                                <img :src="defaultPhoto"  class="img-responsive user-photo">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6><a :href="'/doctor/profile/'+doctor.doctor.id"> @{{ doctor.doctor.firstname }} @{{ doctor.doctor.lastname }}</a></h6>
                            <p>@{{ doctor.created_at}}
                            <p style="font-size: 12px;">Web Dev</p>
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Remove</button>
                 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
       


      
    <div v-show="showLoadMoreBtn" class="row loadmore-container" style="text-align:center;">
           <button value="Load More" @click="loadMore()" style="width:30%;" class="btn btn-primary ladda-button loader" data-style="expand-left"><span class="ladda-label">Load More</span></button>      
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
                this.fetchUserDoctors();
            },

            data(){
                return {
                    lastdate : "",
                    showLoadMoreBtn : true, 
                }
            },

            events: {

            },

            methods: {
           
                    fetchUserDoctors: function(){
                        this.$http.get('/api/user/doctors/get?lastdate='+this.lastdate, function(data){
                            this.userDoctors = data['doctors'];
                        });
                    },

                    loadMore: function(){
                       var lastitem = this.userDoctors[Object.keys(this.userDoctors)[Object.keys(this.userDoctors).length - 1]];
                       this.lastdate = lastitem.created_at;
                       self = this;
                       var l = Ladda.create(document.querySelector( '.loader' ));
                       l.start();
                       this.$http.get('/api/user/doctors/get?lastdate='+this.lastdate, function(data){
                            var doctors = data['doctors'];
                            if(data['remaining'] == 0){
                                self.showLoadMoreBtn = false;
                            }
                            doctors.forEach(function(doctor , index){
                                self.userDoctors.push(doctor);
                            });
                            l.stop();
                        });
                    }
            },

        };
    </script>
@endsection

