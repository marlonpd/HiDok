<template>

    <div class="modal" id="add-genito-urinary-system-form" tabindex="-1" role="dialog" aria-labelledby="add-genito-urinary-system-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Genito Urinary System</h4>
      </div>
          <div class="modal-body">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2"> 
                    <div class="form-group"> 
                        <input v-model="searchkey" class="form-control" placeholder="Search">
                        <br>
                   </div>

                    <div class="row genito-urinary-system-list-pnl">
                        <template v-for="gus in filterBy(genitourinarysystems, searchkey)">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label><input type="checkbox" @click="selectgenitoUrinarySystem($event,gus)" value="">{{ gus }}</label>
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
                <button type="button" @click="submitSelectedgenitoUrinarySystem()" class="btn btn-warning btn-lg genito-urinary-system-loading" style="width: 100%;"><span class="fa fa-plus fa-1"></span>Add</button>
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
                selectedgenitoUrinarySystem : [],
                other: '',
            }
        },

        props : ['genitourinarysystems', 'patient_id', 'consultation_id'],

        events: {},

        methods: {
            selectgenitoUrinarySystem: function(event, skin){
                if($(event.target).is(':checked')){
                    this.selectedgenitoUrinarySystem.push(skin);
                }else{
                    this.selectedgenitoUrinarySystem = this.removeA( this.selectedgenitoUrinarySystem, skin);
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

            submitSelectedgenitoUrinarySystem: function(){
                if(this.other != ''){
                    this.selectedgenitoUrinarySystem.push(this.other);
                }
                var data = { value           : this.selectedgenitoUrinarySystem,
                             patient_id      : this.patient_id      ,
                             consultation_id : this.consultation_id ,
                             type            : 'genito_urinary_system',
                    };
                
                var l = Ladda.create(document.querySelector( '.genito-urinary-system-loading' ));
                l.start();

                this.$http.post('/api/itr/post',data, function(data){
                    if(data['status'] == 'success'){
                        this.$parent.fetchITR('genito_urinary_system');
                        this.other = '';
                        this.selectedgenitoUrinarySystem = [];
                         l.stop();
                        $('#add-genito-urinary-system-form').modal('hide');
                    }
                });
            }
        },

   
    }
</script>

<style>
    .genito-urinary-system-list-pnl{
        height: 280px;
        overflow-y: scroll;
    }
</style>