<template>

    <div class="modal" id="add-abdomen-form" tabindex="-1" role="dialog" aria-labelledby="add-abdomen-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Abdomen</h4>
      </div>
          <div class="modal-body">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row abdomens-list-pnl">
                        <template v-for="abdomen in filterBy(abdomens, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input type="checkbox" @click="selectabdomens($event,abdomen)" value="">{{ abdomen }}</label>
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
                <button type="button" @click="submitSelectedabdomens()" class="btn btn-warning btn-lg abdomen-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedabdomens : [],
                other: '',
            }
        },

        props : ['abdomens', 'patient_id', 'consultation_id'],

        events: {},

        methods: {
            selectabdomens: function(event, abdomen){
                if($(event.target).is(':checked')){
                    this.selectedabdomens.push(abdomen);
                }else{
                    this.selectedabdomens = this.removeA( this.selectedabdomens, abdomen);
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

            submitSelectedabdomens: function(){
                if(this.other != ''){
                    this.selectedabdomens.push(this.other);
                }
                var data = { value           : this.selectedabdomens,
                             patient_id      : this.patient_id      ,
                             consultation_id : this.consultation_id ,
                             type            : 'abdomen',
                    };
                
                var l = Ladda.create(document.querySelector( '.abdomen-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('abdomen');
                        this.other = '';
                        this.selectedabdomens = [];
                         l.stop();
                        $('#add-abdomen-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .abdomens-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }
</style>