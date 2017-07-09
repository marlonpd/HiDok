<template>

    <div class="modal" id="add-diagnosis-form" tabindex="-1" role="dialog" aria-labelledby="add-diagnosis-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Diagnosis</h4>
      </div>
          <div class="modal-body">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row diagnosis-list-pnl">
                        <template v-for="(diagnosis,index) in filterBy(diagnose, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input v-bind:id="'diagnosis'+index" type="checkbox" @click="selectDiagnosis($event,diagnosis,index)" value="">{{ diagnosis }}</label>
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
                <button type="button" @click="submitSelectedDiagnosis()" class="btn btn-warning btn-lg loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedDiagnosis : [],
                indexes : [],  
                other: '',
            }
        },

        props : ['diagnose', 'patient_id', 'consultation_id'],

        events: {},

        methods: {


            selectDiagnosis: function(event, diagnosis, index){
                 if($(event.target).is(':checked')){
                    this.selectedDiagnosis.push(diagnosis);
                    this.indexes.push(index);
                }else{
                    this.selectedDiagnosis = this.removeA( this.selectedDiagnosis, diagnosis);
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

            submitSelectedDiagnosis: function(){
                if(this.other != ''){
                    this.selectedDiagnosis.push(this.other);
                }
                var data = { value        : this.selectedDiagnosis,
                             patient_id      : this.patient_id,
                             consultation_id : this.consultation_id,
                             type : 'diagnosis',
                    };
                var l = Ladda.create(document.querySelector( '.loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('diagnosis');
                        this.other = '';
                        this.indexes.forEach(function(i , index){
                            $('#diagnosis'+i).prop("checked",false);
                        });
                        this.indexes = []; 
                        this.selectedDiagnosis = [];
                        l.stop();
                        $('#add-diagnosis-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .diagnosis-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }
</style>