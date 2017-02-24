@extends('layout')

@section('content')

<div class="container">
    <div class="row">
        
        
        <div class="col-md-12">
        <h4>Clinics</h4>

        <button class="btn btn-primary btn-default" data-title="Create" data-toggle="modal" data-target="#create-clinic-form" ><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Create</button>


        <div class="table-responsive">

                
              <table id="mytable" class="table table-bordred table-striped">
                   
        <thead>
            <th>Name</th>
            <th>Days</th>
            <th>Time</th>
            <th>Address</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
<tbody>

    <template v-for="clinic in clinics">
            <tr class="green-row">
                 <td>@{{ clinic.name }}</td>
                <td>
                    <ul class="no-bullet">
                        <li v-if="clinic.open_sunday == 1">Sunday</li>
                        <li v-if="clinic.open_monday == 1">Monday</li>
                        <li v-if="clinic.open_tuesday == 1">Tuesday</li>
                        <li v-if="clinic.open_wednesday == 1">Wednesday</li>
                        <li v-if="clinic.open_thursday == 1">Thursday</li>
                        <li v-if="clinic.open_friday == 1">Friday</li>
                        <li v-if="clinic.open_saturday == 1">Saturday</li>
                    </ul>

                </td>
                <td>@{{ clinic.from_time }} - @{{ clinic.to_time }}</td>
                <td>@{{ clinic.address }}</td>
                <td><p data-placement="top" data-toggle="tooltip" title="Edit" ><button @click="editClinic(clinic)" class="btn btn-primary btn-xs" data-title="Edit clinic" data-toggle="modal" data-target="#edit-clinic-form" ><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i></button></p></td>
                <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button @click="deleteClinic(clinic)" class="btn btn-danger btn-xs" ><i class="fa fa-trash fa-1" aria-hidden="true"></i></button></p></td>
            </tr>
    </template>

    
   
    
    </tbody>
        
</table>

<div class="clearfix"></div>

                
            </div>
            
        </div>
    </div>
</div>

<create-clinic-form ></create-clinic-form>
<edit-clinic-form :clinic="editableClinic"></edit-clinic-form>

@endsection




@section('javascripts')
    <script>
        var childMixin = {

            mounted(){
              
            },
            created: function() {
                this.fetchClinics(0);
            },



            data: function(){
                return {
                    editableClinic : {}
                }
            },

            methods:{
                editClinic : function(clinic){
                    this.editableClinic = clinic;
                },


                deleteClinic : function(clinic){
                   var self = this; 
                   var editClinic = clinic;

                    swal({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }
                    ).then(function (isConfirm) {

                      if(isConfirm){
                
                        self.$http.post('/api/clinic/delete/post', editClinic.id, function(data){
                          if(data == "success"){
                            
                                swal({
                                  title: 'Success!',
                                  text: 'Successfully deleted! ',
                                  showConfirmButton : false,
                                  timer: 1000,
                                  type : 'success',
                                }).then(
                                  function () {},
                                  function (dismiss) {
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  }
                                );

                            self.fetchClinics(0);
                          }
                        });
             

                      }
                      else
                      {
                          swal("cancelled","Your categories are safe", "error");
                      }

                      
                    });

                },


            }
        };
    </script>
@endsection