<template>

    <div class="modal" id="add-cardiovascular-systems-form" tabindex="-1" role="dialog" aria-labelledby="add-cardiovascularSystems-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Cardiovascular Systems</h4>
      </div>
          <div class="modal-body">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row cardiovascularSystems-list-pnl">
                        <template v-for="(cal,index) in filterBy(cardiovascularsystems, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input v-bind:id="'cardiovascular_system'+index" type="checkbox" @click="selectcardiovascularSystems($event,cal,index)" value="">{{ cal }}</label>
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
                <button type="button" @click="submitSelectedcardiovascularSystems()" class="btn btn-warning btn-lg cal-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedcardiovascularSystems : [],
                other: '',
                indexes : [],  
            }
        },

        props : ['cardiovascularsystems', 'patient_id', 'consultation_id'],

        events: {},

        methods: {
            selectcardiovascularSystems: function(event, skin,index){
                if($(event.target).is(':checked')){
                    this.selectedcardiovascularSystems.push(skin);
                    this.indexes.push(index);
                }else{
                    this.indexes = this.removeA( this.indexes, index);
                    this.selectedcardiovascularSystems = this.removeA( this.selectedcardiovascularSystems, skin);
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

            submitSelectedcardiovascularSystems: function(){
                if(this.other != ''){
                    this.selectedcardiovascularSystems.push(this.other);
                }
                var data = { value           : this.selectedcardiovascularSystems,
                             patient_id      : this.patient_id      ,
                             consultation_id : this.consultation_id ,
                             type            : 'cardiovascular_system',
                    };
                
                var l = Ladda.create(document.querySelector( '.cal-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('cardiovascular_system');
                        this.other = '';
                        this.indexes.forEach(function(i , index){
                            $('#cardiovascular_system'+i).prop("checked",false);
                        });
                        this.selectedcardiovascularSystems = [];
                         l.stop();
                        $('#add-cardiovascular-systems-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .cardiovascularSystems-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }
</style>