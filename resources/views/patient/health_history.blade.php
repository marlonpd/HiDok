@extends('layout')

@section('content')
<div class="container">
    <div class="row">
           <div class="panel panel-default">
                <div class="panel-heading">Consultation History</div>
                <div class="panel-body">
                    
                    <div v-for="consultation in consultations">
                        <span><a :href="'/consultation/'+consultation.id">@{{ consultation.created_at }}</a> - @{{ consultation['doctor'].firstname }} @{{ consultation['doctor'].lastname }}</span>
                        <hr>
                    </div>
                    
                    <br>
                    <br>
                    <div v-show="showLoadMoreBtn" class="row loadmore-container" style="text-align:center;">
                        <button value="Load More" @click="loadMore()" style="width:30%;" class="btn btn-primary ladda-button loader" data-style="expand-left"><span class="ladda-label">Load More</span></button>      
                    </div>
                    <br>
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

