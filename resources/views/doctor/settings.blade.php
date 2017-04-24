@extends('layout')

@section('content')
  <div class="container">
        <doctor-profile-form :constants="constants" :authUser="authUser"></doctor-profile-form>
  </div>
@stop





@section('javascripts')
    <script>

        var childMixin = {

            mounted(){
                    
            },
            created: function() {    

              

            },



            data: function(){
                return {
                   
                }
            },

            methods:{
                
            }

        };
    </script>
@endsection
