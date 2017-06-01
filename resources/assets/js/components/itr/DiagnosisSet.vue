<template>
    <div>
         <div class="control-group" id="fields">
            <div class="controls controls-d"> 
                <form role="form" autocomplete="off">
                    <div class="entry entry-d input-group col-xs-3">
                        <input class="form-control" name="fields[]" type="text" placeholder="Type something" />
                        <span class="input-group-btn">
                            <button class="btn btn-success btn-add-d btn-add btn-side" type="button">
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
            $(document).on('click', '.btn-add-d', function(e)
            {
                e.preventDefault();
                var controlForm = $('.controls-d form:first'),
                    currentEntry = $(this).parents('.entry-d:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                controlForm.find('.entry-d:not(:last) .btn-add-d')
                    .removeClass('btn-add').addClass('btn-remove-d').addClass('btn-side')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
            }).on('click', '.btn-remove-d', function(e)
            {
                $(this).parents('.entry-d:first').remove();

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
