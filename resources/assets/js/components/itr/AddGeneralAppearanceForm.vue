<template>

    <div class="modal" id="add-general-appearances-form" tabindex="-1" role="dialog" aria-labelledby="add-general-appearances-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">General Appearance</h4>
      </div>
          <div class="modal-body">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row general-appearances-list-pnl">
                        <template v-for="ga in filterBy(general_appearances, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input type="checkbox" @click="selectGeneralAppearances($event,ga)" value="">{{ ga }}</label>
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
                <button type="button" @click="submitSelectedGeneralAppearances()" class="btn btn-warning btn-lg general_appearances-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedGeneralAppearances : [],
                other: '',
            }
        },

        props : ['general_appearances', 'patient_id', 'consultation_id'],

        events: {},

        methods: {
            selectGeneralAppearances: function(event, ga){
                if($(event.target).is(':checked')){
                    this.selectedGeneralAppearances.push(ga);
                }else{
                    this.selectedGeneralAppearances = this.removeA( this.selectedGeneralAppearances, ga);
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

            submitSelectedGeneralAppearances: function(){
                if(this.other != ''){
                    this.selectedGeneralAppearances.push(this.other);
                }
                var data = { value           : this.selectedGeneralAppearances,
                             patient_id      : this.patient_id      ,
                             consultation_id : this.consultation_id ,
                             type            : 'general_appearance',
                    };
                
                var l = Ladda.create(document.querySelector( '.general_appearances-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('general_appearance');
                        this.other = '';
                        this.selectedGeneralAppearances = [];
                         l.stop();
                        $('#add-general-appearances-form').modal('hide');
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