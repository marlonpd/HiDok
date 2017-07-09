<template>

    <div class="modal" id="add-laboratory-form" tabindex="-1" role="dialog" aria-labelledby="add-laboratory-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Laboratory</h4>
      </div>
          <div class="modal-body">

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row laboratory-list-pnl">
                        <template v-for="(laboratory,index) in filterBy(laboratories, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input  v-bind:id="'laboratory'+index" type="checkbox" @click="selectlaboratory($event,laboratory,index)" value="">{{ laboratory }}</label>
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
                <button type="button" @click="submitSelectedlaboratory()" class="btn btn-warning btn-lg laboratory-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedlaboratory : [],
                other: '',
                indexes: [],
            }
        },

        props : ['laboratories', 'patient_id', 'consultation_id'],

        events: {},

        methods: {


            selectlaboratory: function(event, laboratory,index){
                if($(event.target).is(':checked')){
                    this.selectedlaboratory.push(laboratory);
                    this.indexes.push(index);
                }else{
                    this.selectedlaboratory = this.removeA( this.selectedlaboratory, laboratory);
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

            submitSelectedlaboratory: function(){

                var data = { value        : this.selectedlaboratory,
                             patient_id      : this.patient_id,
                             consultation_id : this.consultation_id,
                             type : 'laboratory',
                    };
                
                var l = Ladda.create(document.querySelector( '.laboratory-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('laboratory');
                        this.indexes.forEach(function(i , index){
                            $('#laboratory'+i).prop("checked",false);
                        });
                        this.indexes = [];  
                        this.selectedlaboratory = [];
                         l.stop();
                        $('#add-laboratory-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .laboratory-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }
</style>