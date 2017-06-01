<template>

    <div class="modal" id="add-symptoms-form" tabindex="-1" role="dialog" aria-labelledby="add-symptoms-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Symptoms</h4>
      </div>
          <div class="modal-body">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row symptoms-list-pnl">
                        <template v-for="symptom in filterBy(symptoms, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input type="checkbox" @click="selectSymptoms($event,symptom)" value="">{{ symptom }}</label>
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
                <button type="button" @click="submitSelectedSymptoms()" class="btn btn-warning btn-lg symptom-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedSymptoms : [],
                other: '',
            }
        },

        props : ['symptoms', 'patient_id', 'consultation_id'],

        events: {},

        methods: {
            selectSymptoms: function(event, symptom){
                if($(event.target).is(':checked')){
                    this.selectedSymptoms.push(symptom);
                }else{
                    this.selectedSymptoms = this.removeA( this.selectedSymptoms, symptom);
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

            submitSelectedSymptoms: function(){
                if(this.other != ''){
                    this.selectedSymptoms.push(this.other);
                }
                var data = { value           : this.selectedSymptoms,
                             patient_id      : this.patient_id      ,
                             consultation_id : this.consultation_id ,
                             type            : 'chief_complaint',
                    };
                
                var l = Ladda.create(document.querySelector( '.symptom-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('symptom');
                        this.other = '';
                        this.selectedSymptoms = [];
                         l.stop();
                        $('#add-symptoms-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .symptoms-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }

    .ui-autocomplete { z-index:2147483647; }
</style>