<template>
     <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>

                <div class="panel-body">
                    <form action="/settings/update" method="POST">
                       <div class="col-md-6 pull-left">
                            <div class="form-group">
                                <div class="file-preview-thumbnails"><div class="file-default-preview"><img v-bind:src="authUser.avatar"  style="width:200px"></div></div>           
                            </div>

                            <div class="form-group">
                                <label class="btn btn-default file-browse-btn btn-file">
                                Browse  <input name="photo" type="file"></label>
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
                                        <option  v-bind:value="specialization" >{{ specialization }}</option>
                                    </template>
                                </select>
                            
                            </div>


                            <div class="form-group">  
                                <label for="exampleInputEmail1">Gender</label>
                                
                                <select name="gender" id="gender" v-model="authUser.gender"  class="form-control">
                                    <option disabled>Select...</option>
                                    <template v-for="gender in constants['gender']">
                                        <option  v-bind:value="gender" >{{ gender }}</option>
                                    </template>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">E-mail address</label>
                                <input type="email" class="form-control"   placeholder="E-mail" name="email" v-model="authUser.email" required>
                            </div>


                            <div class="form-group">
                              <button class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
                            </div> 


                        </div>

                    </form>
                </div>
            </div>
    </div>
</template>

<script>

    export default {
        mounted() {
          
        },

        props : ['constants'],

        created: function() {
            this.fetchAuthUser();
        },

        data(){
            return {
                authUser : {}
            }
        },

        events: {

        },

        methods: {
            fetchAuthUser: function(){
                this.$http.get('/api/auth/user/get', function(data){
                    this.authUser = data['user'];
                });
            },

        },

   
    }
</script>
