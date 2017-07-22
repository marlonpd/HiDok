@extends('layout')

@section('content')
<div class="container">

        <div class="panel panel-default">
        <div class="panel-heading">Doctors
        
        <div class="pull-right">
            <input type="text" class="form-control input-md" name="searchKey" v-model="searchKey" />
        </div>
        <div class="clr"></div>
        </div>

        <div class="panel-body">



        <div class="row">
        <div class="col-md-4" v-for="doctor in  filterBy(userDoctors,searchKey)">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">

                        <div class="pull-right">
                            <span class="hand-pointer" @click="deletePatient(index , patient, $event)">X</div>
                        </div>

                        <div class="col-md-4">
                            <div v-if="doctor.doctor.thumbnail != ''" class="thumbnail">
                                <img  :src="doctor.doctor.thumbnail" class="img-responsive user-photo">
                            </div>   
                            <div v-else class="thumbnail">
                                    <img :src="defaultPhoto"  class="img-responsive user-photo">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6><a :href="'/doctor/profile/'+doctor.doctor.id"> @{{ doctor.doctor.firstname }} @{{ doctor.doctor.lastname }}</a></h6>
                            <p>@{{ doctor.created_at | formatDate}}</p>
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
       


      
    <div v-if="showLoadMoreBtn" class="row loadmore-container" style="text-align:center;">
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
                    searchKey : '',
                }
            },

            events: {

            },

            methods: {
           
                    fetchUserDoctors: function(){
                        this.$http.get('/api/user/doctors/get?lastdate='+this.lastdate, function(data){
                            this.userDoctors = data['doctors'];
                            if(this.userDoctors.length <= 10){
                                this.showLoadMoreBtn = false;
                            }else{
                                this.showLoadMoreBtn = true;
                            }
                        });
                    },

                    deletePatient: function(index , patient, event){
                        event.preventDefault();
                        var self = this; 
                        var user = patient;

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
                                    self.$http.post( '/api/patient/delete/post' , user ,function(data){
                                        if(data['status'] == 'success'){
                                            self.userPatients.splice(index, 1);
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

