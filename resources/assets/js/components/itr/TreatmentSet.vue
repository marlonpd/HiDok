<template>
    <div>
         <div class="control-group" id="fields">
            <div class="controls controls-t"> 
                <form role="form" autocomplete="off">
                    <div class="entry entry-t input-group col-xs-3">
                        <input class="form-control" name="fields[]" type="text" placeholder="Type something" />
                        <span class="input-group-btn">
                            <button class="btn btn-success btn-add btn-add-t btn-side" type="button">
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
            $(document).on('click', '.btn-add-t', function(e)
            {
                e.preventDefault();
                var controlForm = $('.controls-d form:first'),
                    currentEntry = $(this).parents('.entry-d:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                controlForm.find('.entry-t:not(:last) .btn-add-t')
                    .removeClass('btn-add-t').addClass('btn-remove-t').addClass('btn-side')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
            }).on('click', '.btn-remove-t', function(e)
            {
                $(this).parents('.entry-t:first').remove();

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
