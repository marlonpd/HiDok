<template>
    <div class="modal" id="edit-feeling-form" tabindex="-1" role="dialog" aria-labelledby="edit-feeling-form" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle fa-1" aria-hidden="true"></i></button>
                        <h4 class="modal-title custom_align" id="Heading">Edit Feeling</h4>
                </div>
                <div class="modal-body">   
                            <textarea v-model="feeling.content" placeholder="How do you feel right now?" style="width:100%;"></textarea>
                            
                            <input type="checkbox" name="private" v-model="feeling.public" checkv-bind:true-value="1" v-bind:false-value="0"> Share to doctor
                            
                            
                    </div>
                    <div class="modal-footer ">
                        <button type="submit" @click="saveFeeling($event)" class="btn btn-success green loading"><i class="fa fa-share"></i> Submit</button>
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

        props : ['feeling'],

        created: function() {
           
        },

       
        data(){
            return {
                

            }
        },

        events: {

        },

        methods: {
            saveFeeling: function(event){
                event.preventDefault();

                if(this.feeling.content != ''){
                    var l = Ladda.create(document.querySelector( '.loading' ));
                    l.start();

                    this.$http.post( '/api/feeling/update/post' , this.feeling ,function(data){
                        if(data['status'] == 'success'){
                            
                            l.stop();
                            $('#edit-feeling-form').modal('hide');
                            
                            swal({
                                title: 'Success!',
                                text: 'Successfully updated your post.',
                                showConfirmButton : false,
                                timer: 1000,
                                type : 'success',
                            }).then(
                            function () {},
                            function (dismiss) {
                                if (dismiss === 'timer') {
                                console.log('I was closed by the timer')
                                }
                            }
                            );

                        }else{

                        }
                    });
                }
            },
        },

   
    }
</script>
