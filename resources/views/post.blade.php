@extends('layout')

@section('content')
<div class="container">
  <h4>Post</h4>

  {{ $post->content }}
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

