<template>

    <div class="modal" id="add-skins-form" tabindex="-1" role="dialog" aria-labelledby="add-skins-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Skin</h4>
      </div>
          <div class="modal-body">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row skins-list-pnl">
                        <template v-for="(skin,index) in filterBy(skins, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input  v-bind:id="'skin'+index"  type="checkbox" @click="selectskins($event,skin,index)" value="">{{ skin }}</label>
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
                <button type="button" @click="submitSelectedskins()" class="btn btn-warning btn-lg skin-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedskins : [],
                other: '',
                indexes : [], 
            }
        },

        props : ['skins', 'patient_id', 'consultation_id'],

        events: {},

        methods: {
            selectskins: function(event, skin,index){
                if($(event.target).is(':checked')){
                    this.selectedskins.push(skin);
                    this.indexes.push(index);
                }else{
                    this.selectedskins = this.removeA( this.selectedskins, skin);
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

            submitSelectedskins: function(){
                if(this.other != ''){
                    this.selectedskins.push(this.other);
                }
                var data = { value           : this.selectedskins,
                             patient_id      : this.patient_id      ,
                             consultation_id : this.consultation_id ,
                             type            : 'skin',
                    };
                
                var l = Ladda.create(document.querySelector( '.skin-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('skin');
                        this.other = '';
                        this.indexes.forEach(function(i , index){
                            $('#skin'+i).prop("checked",false);
                        });
                        this.indexes = [];   
                        this.selectedskins = [];
                         l.stop();
                        $('#add-skins-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .skins-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }
</style>