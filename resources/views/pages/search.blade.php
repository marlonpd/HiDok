@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Search results...</div>

                <div class="panel-body">
                    <div class="panel-heading">Doctor</div>

                    @foreach ($doctors as $doc)
                    <!--profile box -->
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <img src="{{$doc->thumbnail}}" alt="" class="img-rounded img-responsive" />
                                </div>
                                <div class="col-sm-6 col-md-8">
                                    <h4>
                                        <a href="/doctor/profile/{{$doc->id}}">{{$doc->lastname}}, {{$doc->firstname}}  {{$doc->middlename}}</a> </h4>
                                    <small><cite title="San Francisco, USA">  {{$doc->address}} <i class="fa fa-map-marker">
                                    </i></cite></small>
                                    <p>
                                        <i class="fa fa-envelope"></i> {{$doc->email}}
                                        <br />
                                        <i class="fa fa-mobile"></i><a href="http://www.jquery2dotnet.com"> {{$doc->contact_no}}</a>
                                        <br />
                                        <i class="fa fa-user-md"></i> {{$doc->specialization}}</p>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end profile box -->
                    @endforeach
                   
                </div>


                <!--hospital -->
                <div class="panel-body">
                    <div class="panel-heading">Medical Facility</div>

                    @foreach ($medical_facilities as $med)
                    <!--profile box -->
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <img src="{{$med->thumbnail}}" alt="" class="img-rounded img-responsive" />
                                </div>
                                <div class="col-sm-6 col-md-8">
                                    <h4>
                                        <a href="/medical_facility/profile/{{$med->id}}">{{$med->name}}</a> </h4>
                                    <small><cite title="San Francisco, USA">  {{$med->address}} <i class="fa fa-map-marker">
                                    </i></cite></small>
                                    <p>
                                        <i class="fa fa-envelope"></i> {{$med->email}}
                                        <br />
                                        <i class="fa fa-mobile"></i><a href="http://www.jquery2dotnet.com"> {{$med->contact_no}}</a>
                                        <br />
                                        <i class="fa fa-user-md"></i> {{$med->specialization}}</p>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end profile box -->
                    @endforeach



                </div>

                 <!--end hospital -->
            </div>
        </div>
    </div>
</div>
@endsection





@section('javascripts')
    <script>
        var childMixin = {

            mounted(){
              
            },
            created: function() {
               
            },

            mounted(){
              
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