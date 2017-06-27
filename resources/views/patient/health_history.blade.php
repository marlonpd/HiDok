@extends('layout')

@section('content')
<div class="container">
    <div class="row">
           <div class="panel panel-default">
                <div class="panel-heading">Consultation History</div>
                <div class="panel-body">
                    

 
                        <div class="shadow"  v-for="consultation in consultations" >
                            <div class="col-sm-12">
                                <div class="col-sm-1">
                                <img :src="'/'+consultation.doctor.thumbnail" width="60px">
                                </div>
                                <div class="col-sm-9">
                                <h4><a :href="'/profile/doctor/'+consultation.doctor.id">@{{ consultation['doctor'].firstname | capitalize }} @{{ consultation['doctor'].lastname | capitalize }}</a></h4>
                                <p><a :href="'/consultation/'+consultation.id" >Consultaiton date : @{{ consultation.created_at }}</a></p>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right">
                                        <a  class="btn btn-success btn-xs glyphicon glyphicon-eye-open" :href="'/consultation/'+consultation.id" title="View"></a>
                                        <!-- <a  class="btn btn-danger  btn-xs glyphicon glyphicon-trash" href="#" title="Delete" @click="deleteConsultation(consultation, $event)"></a>-->
                                    </label>
                                        
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr />
                            <div class="clearfix"></div>
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
                fetchUserConsultations: function(){
                    this.$http.get('/api/patient/consultation/get?lastdate='+this.lastdate, function(data){
                        this.consultations = data['consultations'];

                        if(this.consultations.length <= 10){
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
                    this.$http.get('/api/patient/consultation/get?lastdate='+this.lastdate, function(data){
                        var consultaions = data['consultations'];
                        if(data['remaining'] == 0){
                            self.showLoadMoreBtn = false;
                        }

                        if(data['error'] == 'Unauthenticated'){
                            windows.location = 'http://hidok.com';
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

