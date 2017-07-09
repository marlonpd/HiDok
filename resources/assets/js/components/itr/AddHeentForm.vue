<template>

    <div class="modal" id="add-heent-form" tabindex="-1" role="dialog" aria-labelledby="add-heent-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Heents</h4>
      </div>
          <div class="modal-body">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row heents-list-pnl">
                        <template v-for="(heent,index) in filterBy(heents, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input v-bind:id="'heent'+index" type="checkbox" @click="selectheents($event,heent,index)" value="">{{ heent }}</label>
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
                <button type="button" @click="submitSelectedheents()" class="btn btn-warning btn-lg heent-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedheents : [],
                other: '',
                indexes:[],
            }
        },

        props : ['heents', 'patient_id', 'consultation_id'],

        events: {},

        methods: {
            selectheents: function(event, heent,index){
                if($(event.target).is(':checked')){
                    this.selectedheents.push(heent);
                    this.indexes.push(index);
                }else{
                    this.selectedheents = this.removeA( this.selectedheents, heent);
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

            submitSelectedheents: function(){
                if(this.other != ''){
                    this.selectedheents.push(this.other);
                }
                var data = { value           : this.selectedheents,
                             patient_id      : this.patient_id      ,
                             consultation_id : this.consultation_id ,
                             type            : 'heent',
                    };
                
                var l = Ladda.create(document.querySelector( '.heent-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('heent');
                        this.other = '';
                        this.indexes.forEach(function(i , index){
                            $('#heent'+i).prop("checked",false);
                        });
                        this.indexes = [];   
                        this.selectedheents = [];
                         l.stop();
                        $('#add-heent-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .heents-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }
</style>