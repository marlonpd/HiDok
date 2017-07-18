@extends('layout')

@section('content')
<div class="container">
    <div style="width: 100%; margin: 100px auto !important;">
        <h3 style="text-align: center; text-transform: none;"> An email has been sent to {{ $user->email }}. </h3>
    </div>
</div>
@endsection

@section('javascripts')
    <script>


        var childMixin = {

            mounted() {
            },

            created: function() {
            },

            data(){
                return {
                }
            },

            events: {

            },

            methods: {
            },



        };
    </script>
@endsection

