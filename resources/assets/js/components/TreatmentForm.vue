<template>
    <div class="col-sm-12 well">
        <form accept-charset="UTF-8" action="" method="POST">
            <textarea class="form-control" id="text" name="text" v-model="treatment" placeholder="Type in your message" rows="5"></textarea>
            <h6 class="pull-right" id="count_message"></h6>
            <button class="btn btn-info" type="submit" @click="updateTreatment($event)">Update</button>
        </form>
    </div>
</template>

<script>

    export default {
        mounted() {

        },

        props : ['itr_id', 'treatment'],

        created: function() {
           
        },

       
        data(){
            return {
                
                itr : { 
                    id : null,
                    treatment :  null,
                },

            }
        },

        events: {

        },

        methods: {
            updateTreatment : function(event){

                event.preventDefault();
                this.itr.id = this.itr_id;
                this.itr.treatment = this.treatment;

                this.$http.post('/api/itr/treatment/post', this.itr, function(data){
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
