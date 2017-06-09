@extends('layout')

@section('content')
<div class="container">
    <div class="row">
           <div class="panel panel-default">
                <div class="panel-heading">Treatment Record</div>
                <div class="panel-body">
                    @foreach ($itr_type as $key=>$value)
                        *{{ $value }} <br>
                        @foreach($itr[$key] as $i)
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-{{ trim($i->value) }}</span><br>
                        @endforeach
                        <br><br>
                    @endforeach
                </div>
           </div>     
    </div>
</div>
@endsection

@section('javascripts')
    <script>


        var childMixin = {
            mounted() {},

            created: function() {
            },

            data(){
                return {
                }
            },

            events: {},

            methods: {

 
      
            },



        };
    </script>
@endsection

