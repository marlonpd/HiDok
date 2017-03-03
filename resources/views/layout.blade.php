<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" id="csrf-token">

        <title>HiDok</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <link rel="stylesheet" type="text/css" href="/css/all.css">
        <link rel="stylesheet" type="text/css" href="/css/theme.css">
    </head>
    <body >
      <div id="app">
     
               <nav class="navbar navbar-inverse navbar-top">
                  <div class="container">
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="/home"><img src="/images/logo.png" alt="" width="60px;" class="img-rounded img-responsive"><h4>HiDok</h4></a>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                      <ul class="nav navbar-nav">
                        <li>
                          <a href="/home">HOME</a>
                        </li>

                        <li>
                          <a href="/about">ABOUT</a>
                        </li>

                        <li>
                          <a href="/contact">CONTACT</a>
                        </li>

                           @if (Auth::check())
                             @if(Auth::user()->is_doctor())
                                <li><a href="/clinics">CLINICS</a></li>
                                 <li><a href="/feedback">FEEDBACK</a></li>
                             @endif
                          @endif

                        

                      </ul>

                      <ul class="nav navbar-nav pull-right">
                          @if (Auth::check())

                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-search"></i></a>
                              <ul class="dropdown-menu" style="padding:12px;">
                                  <form class="form-inline" action="/search" method="get">
                                  <select class="form-control pull-left" name="account">
                                    <option value="doctor">Doctor</option>
                                    <option value="hospital">Hospital</option>
                                    <option value="laboratory">Laboratory</option>
                                    <option value="pharmacy">Pharmacy</option>
                                  </select>
                              <button type="submit" class="btn btn-default pull-right"><i class="glyphicon glyphicon-search"></i></button><input class="form-control pull-left" placeholder="Search" type="text" name="name">
                                  </form>
                                </ul>
                            </li>
                          @endif
                  
                        @if (!Auth::check())
           
                          <li><a  href="#" data-title="Login" data-toggle="modal" data-target="#login"><i class="fa fa-user" aria-hidden="true"></i>Login</a></li>
                        @else
                          <li><a href="/logout"><i class="fa fa-user" aria-hidden="true"></i>Logout</a></li>
                        @endif
                       
           
                      </ul>

                    </div><!--/.nav-collapse -->
                  </div>
                </nav>
                
              <div class="main-container" >
                  @yield('content')
              </div>
   
              @if (!Auth::check())
                <register></register>
                <login-form ></login-form>
              @endif

              @include('partials.top_footer')
              @include('partials.footer')
                       
              @include('partials.flash')

            </div>
            

            <script src="/js/all.js"></script>
   

            
            @yield('javascripts')

            <script type="text/javascript">
              var main = {

                

                mounted(){
                    
                },
                created: function() {    
                  @if (Auth::check())
                     this.fetchConstants();
                     this.setAuthUser('{!! Auth::user() !!}');         
                  @endif 
                },

                data: function(){
                    return {
                      dev : null,
                      id : null,
                      authUser : {},
                    }
                },

                methods:{
                  setAuthUser : function(authUser){
                      this.authUser = JSON.parse(authUser);
                  },


                }
              };

            </script>
            

            <script src="/js/app.js"></script>

            <feedback></feedback>
    </body>
</html>
