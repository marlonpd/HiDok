<template>

    <div class="modal" id="add-extremity-form" tabindex="-1" role="dialog" aria-labelledby="add-extremity-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Extremities</h4>
      </div>
          <div class="modal-body">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row extremities-list-pnl">
                        <template v-for="(extremity,index) in filterBy(extremities, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input v-bind:id="'extremities'+index" type="checkbox" @click="selectextremities($event,extremity,index)" value="">{{ extremity }}</label>
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
                <button type="button" @click="submitSelectedextremities()" class="btn btn-warning btn-lg extremity-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedextremities : [],
                other: '',
                indexes : [],
            }
        },

        props : ['extremities', 'patient_id', 'consultation_id'],

        events: {},

        methods: {
            selectextremities: function(event, skin, index ){
                if($(event.target).is(':checked')){
                    this.selectedextremities.push(skin);
                    this.indexes.push(index);
                }else{
                    this.selectedextremities = this.removeA( this.selectedextremities, skin);
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

            submitSelectedextremities: function(){
                if(this.other != ''){
                    this.selectedextremities.push(this.other);
                }
                var data = { value           : this.selectedextremities,
                             patient_id      : this.patient_id      ,
                             consultation_id : this.consultation_id ,
                             type            : 'extremities',
                    };
                
                var l = Ladda.create(document.querySelector( '.extremity-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('extremities');
                        this.other = '';
                        this.indexes.forEach(function(i , index){
                            $('#extremities'+i).prop("checked",false);
                        });
                        this.indexes = [];  
                        this.selectedextremities = [];
                         l.stop();
                        $('#add-extremity-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .extremities-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }
</style>