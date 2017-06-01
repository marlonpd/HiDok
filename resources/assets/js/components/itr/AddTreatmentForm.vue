<template>

    <div class="modal" id="add-treatment-form" tabindex="-1" role="dialog" aria-labelledby="add-treatment-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Treatment</h4>
      </div>
          <div class="modal-body">
                <input id="treatment-autocomplete" v-model="selectedTreatment" autofocus type="text" name="q" placeholder="Treatment..." style="width:100%;max-width:600px;outline:0">
                                          
          </div>
          <div class="modal-footer ">
                <button type="button" @click="submitSelectedTreatment()" class="btn btn-warning btn-lg treatment-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedTreatment : null,
                other: '',
            }
        },

        props : ['treatment', 'patient_id', 'consultation_id'],

        events: {},

        methods: {


            selectTreatment: function(event, treatment){
                if($(event.target).is(':checked')){
                    this.selectedTreatment.push(treatment);
                }else{
                    this.selectedTreatment = this.removeA( this.selectedTreatment, treatment);
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

            submitSelectedTreatment: function(){

                var data = { value        :  $('#treatment-autocomplete').val(),   
                             patient_id      : this.patient_id,
                             consultation_id : this.consultation_id,
                             type : 'treatment',
                    };
                
                var l = Ladda.create(document.querySelector( '.treatment-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('treatment');
                        this.selectedTreatment = null;
                        $('#treatment-autocomplete').val(''), 
                         l.stop();
                        $('#add-treatment-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .treatment-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }
</style>