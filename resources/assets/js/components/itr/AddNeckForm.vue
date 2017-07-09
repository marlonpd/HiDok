<template>

    <div class="modal" id="add-necks-form" tabindex="-1" role="dialog" aria-labelledby="add-necks-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Neck</h4>
      </div>
          <div class="modal-body">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row necks-list-pnl">
                        <template v-for="(neck,index) in filterBy(necks, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input  v-bind:id="'neck'+index"  type="checkbox" @click="selectnecks($event,neck,index)" value="">{{ neck }}</label>
                                </div>
                            </div>
                        </template>
                    </div>  
                     <br>
                     <div class="form-group"> 
                         <input v-model="other" class="form-control" placeholder="Other"> 
                    </div>                     
          </div>
          <div class="modal-footer ">
                <button type="button" @click="submitSelectednecks()" class="btn btn-warning btn-lg neck-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
          </div>
    </div>

        
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
</div>
    
</template>

<script>
    

    export default {
        mounted() {

        },

        created: function() {
           
        },

       
        data(){
            return {
                searchkey : '',
                selectednecks : [],
                other: '',
                indexes : [],          
            }
        },

        props : ['necks', 'patient_id', 'consultation_id'],

        events: {},

        methods: {
            selectnecks: function(event, neck,index){
                if($(event.target).is(':checked')){
                    this.selectednecks.push(neck);
                    this.indexes.push(index);
                }else{
                    this.selectednecks = this.removeA( this.selectednecks, neck);
                    this.indexes = this.removeA( this.indexes, index);
                }
            },

            removeA: function(arr) {
                var what, a = arguments, L = a.length, ax;
                while (L > 1 && arr.length) {
                    what = a[--L];
                    while ((ax= arr.indexOf(what)) !== -1) {
                        arr.splice(ax, 1);
                    }
                }
                return arr;
            },

            submitSelectednecks: function(){
                if(this.other != ''){
                    this.selectednecks.push(this.other);
                }
                var data = { value           : this.selectednecks,
                             patient_id      : this.patient_id      ,
                             consultation_id : this.consultation_id ,
                             type            : 'neck',
                    };
                
                var l = Ladda.create(document.querySelector( '.neck-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('neck');
                        this.other = '';
                        this.indexes.forEach(function(i , index){
                            $('#neck'+i).prop("checked",false);
                        });
                        this.indexes = [];  
                        this.selectednecks = [];
                         l.stop();
                        $('#add-necks-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .necks-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }
</style>