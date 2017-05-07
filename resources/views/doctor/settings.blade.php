@extends('layout')

@section('content')
  <div class="container">
         <div class="panel panel-default">
                <div class="panel-heading">Profile</div>

                <div class="panel-body">
                    <form action="/settings/update" method="POST">
                       <div class="col-md-6 pull-left">
                            <div class="form-group">
                                <div class="file-preview-thumbnails"><div class="file-default-preview"><img :src="authUser.thumbnail"  style="width:200px"></div></div>           
                            </div>

                            <div class="form-group">
                                <label class="btn btn-default file-browse-btn btn-file">
                                Browse  <input @change="updatePhoto()" name="photo" id="photo" type="file"></label>
                            </div>


                             <div class="form-group">
                              <label for="exampleInputEmail1">Last name</label>
                              <input type="text" class="form-control"  placeholder="lastname" name="lastname" id="lastname" v-model="authUser.lastname" required>
                            </div>


                             <div class="form-group">
                              <label for="exampleInputEmail1">First name</label>
                              <input type="text" class="form-control"   placeholder="Firstname" name="firstname" id="firstname"  v-model="authUser.firstname" required>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputEmail1">Middle name</label>
                              <input type="text" class="form-control"   placeholder="Middlename" name="middlename" id="middlename" v-model="authUser.middlename" required>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputEmail1">Address</label>
                              <input type="text" class="form-control" placeholder="Address" name="address" id="address" v-model="authUser.address" required>
                            </div>





                       </div>

                       <div class="col-md-6 pull-right">
                            <div class="form-group">  
                                <label for="exampleInputEmail1">Specialization</label>
                                
                                <select name="specialization" id="specialization" v-model="authUser.specialization"  class="form-control">
                                    <option disabled>Select...</option>
                                    <template v-for="specialization in constants['specialization']">
                                        <option  v-bind:value="specialization" >@{{ specialization }}</option>
                                    </template>
                                </select>
                            
                            </div>


                            <div class="form-group">  
                                <label for="exampleInputEmail1">Gender</label>
                                
                                <select name="gender" id="gender" v-model="authUser.gender"  class="form-control">
                                    <option disabled>Select...</option>
                                    <template v-for="gender in constants['gender']">
                                        <option  v-bind:value="gender" >@{{ gender }}</option>
                                    </template>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">E-mail address</label>
                                <input type="email" class="form-control"   placeholder="E-mail" name="email" v-model="authUser.email" required>
                            </div>


                


                        </div>
                        <div class="col-md-12" >
                              <button @click="updateProfile($event)" class="btn-submit-primary btn btn-lg btn-primary btn-block" type="submit">Update</button>
                        </div> 


                    </form>
                </div>
            </div>

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
                updateProfile:function(event){
                    event.preventDefault();
                    var l = Ladda.create(document.querySelector( '.btn-submit-primary' ));
                    l.start();
                    this.$http.post('/api/update/profile/post', this.authUser, function(data){
                        l.stop();
                        if(data['status'] =='success'){
                            swal({
                                title: 'Info!',
                                text: 'Success.',
                                showConfirmButton : false,
                                timer: 1000,
                                type : 'success',
                            }).then(function () {},function (dismiss) {});
                        }else{
                           swal({
                                title: 'Info!',
                                text: 'Error. Try again!',
                                showConfirmButton : false,
                                timer: 1000,
                                type : 'error',
                            }).then(function () {},function (dismiss) {});
                        }
                    });
                },

                updatePhoto: function(){
                    var request = new XMLHttpRequest();
                    var formData = new FormData();
                    formData.append('user_id', this.authUser.id);
                    formData.append('photo', $('#photo')[0].files[0]);
                    formData.append('_token',  '{!! csrf_token() !!}');
                    self = this;
                    request.onreadystatechange = function() {
                        if (request.readyState == 4) {
                            var obj = jQuery.parseJSON(request.responseText);
                            if(obj['status'] == "success"){
                                self.authUser.photo = obj['user']['photo'];
                                self.authUser.thumbnail = obj['user']['thumbnail'];
                            }else{
                                alert('error!');
                            }
                        }
                    }
                    request.open('post', '/api/upload/user/photo', true);
                    request.send(formData);
                }

                
            }

        };
    </script>
@endsection
