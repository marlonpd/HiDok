@extends('layout')

@section('content')
<div class="container">
    <div class="row">
           <div class="panel panel-default">
                <div class="panel-heading">Consultations</div>
                <div class="panel-body">
                    
                    


                    <div class="row">
                         <div class="shadow"  v-for="consultation in consultations" >
                                <div class="col-sm-12">
                                    <div class="col-sm-1">
                                    <img :src="consultation.patient.thumbnail" width="60px">
                                    </div>
                                    <div class="col-sm-9">
                                    <h4><a :href="'/patient/consultations/'+consultation['patient'].id">@{{ consultation['patient'].firstname }} @{{ consultation['patient'].lastname }}</a></h4>
                                    <p><a href="#">Consultaiton date : @{{ consultation.created_at }}</a></p>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="pull-right">
                                            
                                            <a  class="btn btn-success btn-xs glyphicon glyphicon-eye-open" :href="'/consultation/'+consultation.id" title="View"></a>
                                            <a  class="btn btn-danger  btn-xs glyphicon glyphicon-trash" href="#" title="Delete" @click="deleteConsultation(consultation, $event)"></a>
                                        </label>
                                            
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr />
                                <div class="clearfix"></div>
                            </div>
                    </div>
                    
                    <br>
                    <br>
                    
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
            mounted() {
            },

            created: function() {
                this.fetchUserConsultations();
            },

            data(){
                return {
                    lastdate : "",
                    showLoadMoreBtn : true, 
                    consultations : {},

                    
                }
            },

            events: {
            },

            methods: {

                deleteConsultation: function(consultation, event){
                    
                    event.preventDefault();
                    self = this;
                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, continue!'
                    }).then(function (isConfirm) {

                            if(isConfirm){
                                self.$http.post('/api/consultation/delete/post', consultation ,function(data){
                                    if(data['status'] == 'success'){
                                        self.fetchUserConsultations();
                                    }else{
                                         swal("Error","Please try again!", "error");
                                    }
                                });
                            }
                            else
                            {
                                swal("cancelled","Your categories are safe", "error");
                            }

                    
                    });
                },

                fetchUserConsultations: function(){
                    this.$http.get('/api/doctor/consultations/get?lastdate='+this.lastdate, function(data){
                        this.consultations = data['consultations'];
                        
                        if(this.consultations.length <= 10 ){
                            this.showLoadMoreBtn = false;
                        }else{
                            this.showLoadMoreBtn = true;
                        }
                    });
                },
                
                loadMore: function(){
                    var lastitem = this.consultations[Object.keys(this.consultations)[Object.keys(this.consultations).length - 1]];
                    this.lastdate = lastitem.created_at;
                    self = this;
                    var l = Ladda.create(document.querySelector( '.loader' ));
                    l.start();
                    this.$http.get('/api/doctor/consultations/get?lastdate='+this.lastdate, function(data){
                        var consultaions = data['consultations'];
                        if(data['remaining'] == 0){
                            self.showLoadMoreBtn = false;
                        }

                        if(data['error'] == 'Unauthenticated'){
                            windows.location = 'http://'+this.APP_DOMAIN;
                        }

                        consultaions.forEach(function(consultaion , index){
                            self.consultations.push(consultaion);
                        });
                        l.stop();
                    });
                }

            },
        };
    </script>
@endsection

