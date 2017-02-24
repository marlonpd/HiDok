<template>
    <div class="col-sm-12 well">
        <form accept-charset="UTF-8" action="" method="POST">
            <textarea class="form-control" id="text" name="text" v-model="diagnosis" placeholder="Type in your message" rows="5"></textarea>
            <h6 class="pull-right" id="count_message"></h6>
            <button class="btn btn-info" type="submit" @click="updatediagnosis($event)">Update</button>
            <a class="btn btn-info" target="_blank" @click="printdiagnosis(itr_id)" ><i class="fa fa-print" aria-hidden="true"></i>Print</a>

        </form>
    </div>
</template>

<script>

    export default {
        mounted() {

        },

        props : ['itr_id', 'diagnosis'],

        created: function() {
           
        },

       
        data(){
            return {
                
                itr : { 
                    id : null,
                    diagnosis :  null,
                },

            }
        },

        events: {

        },

        methods: {
            updatediagnosis : function(event){

                event.preventDefault();
                this.itr.id = this.itr_id;
                this.itr.diagnosis = this.diagnosis;

                this.$http.post('/api/itr/diagnosis/post', this.itr, function(data){
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
            },


            printdiagnosis: function(id){
                window.open('/print/diagnosis/'+id, '_blank', 'location=yes,height=370,width=450,scrollbars=yes,status=yes');
            }

        },


        

   
    }
</script>
