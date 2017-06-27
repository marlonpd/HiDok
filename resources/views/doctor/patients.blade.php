@extends('layout')

@section('content')
<div class="container">
    <div class="row" >

      

        <div class="panel panel-default">
        <div class="panel-heading">Patients</div>

        <div class="panel-body">

        <div class="col-md-4" v-for="(patient, key, index) in userPatients">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                       <div class="pull-right">
                            <span class="hand-pointer" @click="deletePatient(index , patient, $event)">X</div>
                        </div>

                        <div class="col-md-4">
                            <img  :src="patient.patient.thumbnail" class="img-responsive user-photo thumb">
                        </div>
                        <div class="col-md-8">
                            <h6><a :href="'/patient/profile/'+patient.patient.id"> @{{ patient.patient.firstname }} @{{ patient.patient.lastname }}</a></h6>
                            <p>@{{ patient.created_at}}
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
</div>

</div>
@endsection

@section('javascripts')
    <script>
        var childMixin = {

            mounted() {  
            },

            created: function() {
                this.fetchUserPatients();
            },

            data(){
                return {
                    lastdate : "",
                    showLoadMoreBtn : true, 
                    userPatients : {},
                }
            },

            events: {
            },

            methods: {
                    fetchUserPatients: function(){
                        this.$http.get('/api/user/patients/get?lastdate='+this.lastdate, function(data){
                            this.userPatients = data['patients'];
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
                       var lastitem = this.userPatients[Object.keys(this.userPatients)[Object.keys(this.userPatients).length - 1]];
                       this.lastdate = lastitem.created_at;
                       self = this;
                       var l = Ladda.create(document.querySelector( '.loader' ));
                       l.start();
                       this.$http.get('/api/user/patients/get?lastdate='+this.lastdate, function(data){
                            var patients = data['patients'];
                            if(data['remaining'] == 0){
                                self.showLoadMoreBtn = false;
                            }
                            if(data['error'] == 'Unauthenticated'){
                                windows.location = 'http://hidok.dev';
                            }

                            patients.forEach(function(patient , index){
                                self.userPatients.push(patient);
                            });
                            l.stop();
                        });
                    }
            },
        };
    </script>
@endsection

