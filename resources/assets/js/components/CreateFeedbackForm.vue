<template>

    <div class="modal" id="create-feedback-form" tabindex="-1" role="dialog" aria-labelledby="create-feedback-form" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
        <h4 class="modal-title custom_align" id="Heading">Write Feedback</h4>
      </div>
          <div class="modal-body">
         
            


                <div class="row">
                  
                   <div class="status-upload">
                      <form>
                        <textarea v-model="newFeedback.content" placeholder="Add some feedback?" ></textarea>
                        
                     </form>
                    </div><!-- Status Upload  -->
           
                </div>





          </div>
          <div class="modal-footer ">
        <button type="button" @click="submitFeedback($event)" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Submit</button>
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

        props : ['doctor_id'],

        created: function() {

        },



        data(){
            return {
               newFeedback :{
                    id : null,
                    doctor_id : this.doctor_id,
                    content: null,
                }
            }
        },

        events: {

        },

        methods: {
             submitFeedback: function(event){
                    event.preventDefault();

                    swal({
                      text: 'Submitting....',
                      timer: 1000,
                      showConfirmButton : false,
                      type : 'info',
                    }).then(
                      function () {},
                      function (dismiss) {
                      }
                    )

                    self = this;
                    this.$http.post('/api/feedback/post', this.newFeedback,function(data){
                        if(data == "success"){
                            swal({
                              title: 'Success!',
                              text: 'Successfully sent your feedback.',
                              showConfirmButton : false,
                              timer: 1000,
                              type : 'success',
                            }).then(
                              function () {},
                              function (dismiss) {
                                if (dismiss === 'timer') {
                                  console.log('I was closed by the timer');
                                  self.newFeedback.content = '';
                                  $('#create-feedback-form').modal('hide');

                                }
                              }
                            );
                        }else{


                             swal({
                                title: 'Error!',
                                text: 'Unable to submit ur feedback, please try again!',
                                timer: 1000,
                                type : 'error',
                                showConfirmButton : false,
                              }).then(
                                function () {},
                                function (dismiss) {
                                  if (dismiss === 'timer') {
                                    console.log('I was closed by the timer')
                                  }
                                }
                              )

                        }
                    });

                }

  
        },

   
    }
</script>
