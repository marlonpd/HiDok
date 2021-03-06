@extends('layout')

@section('content')

<div class="container">
    <div class="row">
        
        
        <div class="col-md-12">
        <h4>Schedule</h4>

        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#create" ><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Create</button>


        <div class="table-responsive">

                
              <table id="mytable" class="table table-bordred table-striped">
                   
        <thead>
            <th>Days</th>
            <th>Time</th>
            <th>Address</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
<tbody>

    <template v-for="schedule in schedules">
            <tr class="green-row">

                <td>@{{ schedule.from_day }}-@{{ schedule.to_day }}</td>
                <td>@{{ schedule.from_time }} - @{{ schedule.to_time }}</td>
                <td>@{{ schedule.address }}</td>
                <td><p data-placement="top" data-toggle="tooltip" title="Edit" @click="editScheduleShow(schedule)"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit-schedule" ><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i></button></p></td>
                <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button @click="deleteSchedule(schedule)" class="btn btn-danger btn-xs" ><i class="fa fa-trash fa-1" aria-hidden="true"></i></button></p></td>
            </tr>
    </template>

    
   
    
    </tbody>
        
</table>

<div class="clearfix"></div>

                
            </div>
            
        </div>
    </div>
</div>




<create-schedule :schedules="schedules"></create-schedule>

<edit-schedule :schedule="editSchedule"></edit-schedule>

 <create-clinic-form ></create-clinic-form>   

@endsection




@section('javascripts')
      <script type="text/javascript">
          var childMixin = {

            created: function() {
              this.fetchSchedules(0);
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