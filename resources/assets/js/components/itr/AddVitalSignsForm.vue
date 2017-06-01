<template>

    <div class="modal" id="add-vital-signs-form" tabindex="-1" role="dialog" aria-labelledby="add-vital-signs-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">vital-signs</h4>
      </div>
          <div class="modal-body">

                  <input id="vital-sign-autocomplete" v-model="value" autofocus type="text" name="q" placeholder="Vital sign..." style="width:100%;max-width:600px;outline:0">
                              
          </div>
          <div class="modal-footer ">
                <button type="button" @click="submitSelectedVitalSigns()" class="btn btn-warning btn-lg vital-sign-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedVitalSigns : [],
                other: '',
                value : null
            }
        },

        props : ['vitalsigns', 'patient_id', 'consultation_id'],

        events: {},

        methods: {

            fetchVitalSign:function(){
                this.$http.get('/api/terms/get?type=vital_sign',function(data){
                   
                });
            },

            selectVitalSign: function(event, vitalSign){
                 if($(event.target).is(':checked')){
                    this.selectedVitalSigns.push(vitalSign);
                }else{
                    this.selectedVitalSigns = this.removeA( this.selectedVitalSigns, vitalSign);
                }
                
            },

             onOptionSelect(option) {
                console.log('Selected option:', option)
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

            submitSelectedVitalSigns: function(){
                if(this.other != ''){
                    this.selectedVitalSigns.push(this.other);
                }
                var data = { patient_id      : this.patient_id,
                             consultation_id : this.consultation_id,
                             type            : 'vital_sign',
                             value           : $('#vital-sign-autocomplete').val(),   
                };

                var l = Ladda.create(document.querySelector( '.vital-sign-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('vital_sign');
                        this.other = '';
                        this.selectedVitalSigns = '';
                        l.stop();
                        $('#add-vital-signs-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>


<style>
    .vital-signs-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }




</style>