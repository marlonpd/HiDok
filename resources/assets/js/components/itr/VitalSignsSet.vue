<template>
    <div>
         <div class="control-group" id="fields">
            <div class="controls controls-vs"> 
                <form role="form" autocomplete="off">
                    <div class="entry entry-vs input-group col-xs-3">
                        <input class="form-control" name="fields[]" type="text" placeholder="Type something" />
                        <span class="input-group-btn">
                            <button class="btn btn-success btn-add btn-add-vs btn-side" type="button">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </span>
                    </div>
                </form>
            <br>
            <small>Press <span class="glyphicon glyphicon-plus gs"></span> to add another.</small>
            </div>
        </div>
    
    </div>
</template>

<script>
        $(function()
        {
            $(document).on('click', '.btn-add-vs', function(e)
            {
                e.preventDefault();
                var controlForm = $('.controls-vs form:first'),
                    currentEntry = $(this).parents('.entry-vs:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                controlForm.find('.entry-vs:not(:last) .btn-add-vs')
                    .removeClass('btn-add-vs').addClass('btn-remove-vs').addClass('btn-side')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
            }).on('click', '.btn-remove-vs', function(e)
            {
                $(this).parents('.entry-vs:first').remove();

                e.preventDefault();
                return false;
            });
        });

    export default {
        mounted() {

        },

        created: function() {
           
        },

       
        data(){
            return {
                
                user : {
                    
                },

            }
        },

        props: ['consultation_id'],

        events: {

        },

        methods: {
            test: function(){
                alert(this.consultation_id);
            }


        },

   
    }
</script>
