<template>
    <div class="col-sm-12 well">
        <form accept-charset="UTF-8" action="" method="POST">
            <textarea class="form-control" id="text" name="text" v-model="laboratory" placeholder="Type in your message" rows="5"></textarea>
            <h6 class="pull-right" id="count_message"></h6>
            <button class="btn btn-info" type="submit" @click="updateLaboratory($event)">Update</button>
        </form>
    </div>
</template>

<script>

    export default {
        mounted() {

        },

        props : ['itr_id', 'laboratory'],

        created: function() {
           
        },

       
        data(){
            return {
                
                itr : { 
                    id : null,
                    laboratory :  null,
                },

            }
        },

        events: {

        },

        methods: {
            updateLaboratory : function(event){

                event.preventDefault();
                this.itr.id = this.itr_id;
                this.itr.laboratory = this.laboratory;

                this.$http.post('/api/itr/laboratory/post', this.itr, function(data){
                    if(data == 'success'){
                      swal(
                          'Good job!',
                          'You clicked the button!',
                          'success'
                      )  
                      
                    }else{
                      swal("Error","Please try again!", "error");
                    }
                });
            }

        },

   
    }
</script>
