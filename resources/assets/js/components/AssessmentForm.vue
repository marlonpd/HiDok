<template>
    <div class="col-sm-12 well">
        <form accept-charset="UTF-8" action="" method="POST">
            <textarea class="form-control" id="text" name="text" v-model="assessment" placeholder="Type in your message" rows="5"></textarea>
            <h6 class="pull-right" id="count_message"></h6>
            <button class="btn btn-info" type="submit" @click="updateAssement($event)">Update</button>
        </form>
    </div>
</template>

<script>

    export default {
        mounted() {

        },

        props : ['itr_id', 'assessment'],

        created: function() {
           
        },

       
        data(){
            return {
                
                itr : { 
                    id : null,
                    assessment :  null,
                },

            }
        },

        events: {

        },

        methods: {
            updateAssement : function(event){

                event.preventDefault();
                this.itr.id = this.itr_id;
                this.itr.assessment = this.assessment;

                this.$http.post('/api/itr/assessment/post', this.itr, function(data){
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
