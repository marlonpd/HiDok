@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Appointments</div>

                <div class="panel-body">

                    <div id="accordion">
                      
                       @foreach ($schedules as $schedule)
                          <h3>{{ $schedule->address }}, {{ $schedule->from_day }}-{{ $schedule->to_day }} @ {{ $schedule->from_time }} - {{ $schedule->to_time }}</h3>
                          <div>
                            <p>
                                <schedule-appointment :schedule_id = {!! $schedule->id !!} ></schedule-appointment>
                            </p>
                          </div>
                       @endforeach
                     
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>


<re-schedule :schedule="schedule" :id="{!! Auth::user()->id !!}" ></re-schedule>

@endsection




@section('javascripts')
    <script>
        $( function() {
            $( "#accordion" ).accordion();
        });

        var childMixin = {

            mounted(){
                
            },
            created: function() {
                //this.fetchAppointment();
                //this.fetchSchedules('{!! Auth::user()->id !!}');                
            },



            data: function(){
                return {
                   schedule : {},     
                }
            },

            methods:{



            }

        };
    </script>
@endsection