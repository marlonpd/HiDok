@extends('layout')

@section('content')
<div class="container">
      <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
              <div class="col-md-3 pull-left">
                
                <div class="row" align="center"> 
                  <img alt="User Pic" src="{{$user->thumbnail}}" class="img-circle img-responsive"> 
                </div>
                 <span  class="row"> <h4 class="name-title">{{ $user->fullname() }} </h4>
                  <span > {{$user->specialization}}</span>
                 </span>
                 

                 <span class="row">
                    <a type="button" class="btn default-btn btn-block" href="/itr/{{ $user->id }}">Individual Treatment Record</a>
                 </span>

                 

                 


                
              </div>

              <div class="col-md-9 pull-left">
                  <div class="row gmap-clinic-pnl">
                      <div class="clinic-pnl col-md-4 pull-left">
              
                      </div>

                      <div class="gmap-pnl col-md-8 pull-right">
                           <div class="gmap-container">
                              <div id="map_canvas" style="width:100%;height: 100%;"></div>
                           </div>
                      </div>
                  </div>

                  <div class="additional-detail-pnl row">
                    <h4>Qualifications and Experience</h4>

                    <div class="form-horizontal">
                      <div class="form-group">
                          <label class="col-sm-3" for="inputEmail1">Email</label>
                           <div class="col-sm-9"> email@yahoo.com</div>
                      </div>
                    
                       <div class="form-group">
                       <label class="col-sm-3" for="inputEmail1">Email</label>
                           <div class="col-sm-9"> email@yahoo.com</div>
                      </div>

                      <div class="form-group">
                       <label class="col-sm-3" for="inputEmail1">Email</label>
                           <div class="col-sm-9"> email@yahoo.com</div>
                      </div>

                    </div>


                    
                  </div>
              </div>

            </div>
       </div>
</div>



@endsection


@section('javascripts')
<script type="text/javascript">


          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });  
          
          var childMixin = {

            created: function() {
            },

            mounted(){
              

              
            },

            data: function(){
                return {
       
                }
            },

            methods:{
                askConnect: function(){
                  swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then(function () {
                    swal(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                  })
                },

                requestConnect: function(){
                    var data = {doctor_id : '{!! $user->id !!}' }
                    this.$http.post('/api/request/connect/post', data, function(data){
                      if(data['status'] == 'success'){
                        
                      }else{
                        swal("Error","Please try again!", "error");
                      }
                    });
                }
                

            }
          };

      </script>
@endsection