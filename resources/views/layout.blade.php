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
                                <li><a href="/clinic">CLINICS</a></li>
                                 <li><a href="/feedback">FEEDBACK</a></li>
                             @endif
                          @endif

                        

                      </ul>

                      <ul class="nav navbar-nav pull-right">
                          @if (Auth::check())

                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-search"></i></a>
                              <ul class="dropdown-menu search-menu" style="padding:12px;">
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
                          <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <i class="glyphicon glyphicon-bell"></i>
                              </a>
                              <ul class="dropdown-menu notifications notification-menu" role="menu" aria-labelledby="dLabel">
                                
                                <div class="notification-heading"><h4 class="menu-title">Notifications</h4><h4 class="menu-title pull-right">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4>
                                </div>
                                <li class="divider"></li>
                              <div class="notifications-wrapper">
                                <a class="content" href="#">
                                  
                                  <div class="notification-item">
                                    <h4 class="item-title">Appointment 1 · day ago</h4>
                                    <p class="item-info">Jose Rizal requested an appointment</p>
                                  </div>
                                  
                                </a>
                                <a class="content" href="#">
                                  <div class="notification-item">
                                    <h4 class="item-title">Feedback · day ago</h4>
                                    <p class="item-info">Nardong Putik gives you a feedback</p>
                                  </div>
                                </a>
                                

                              </div>
                                <li class="divider"></li>
                                <div class="notification-footer"><h4 class="menu-title">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4></div>
                              </ul>
                          </li>



                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span> 
                                <strong>{{ Auth::user()->firstname }}</strong>
                                <span class="glyphicon glyphicon-chevron-down"></span>
                            </a>
                            <ul class="dropdown-menu account-menu">
                                <li>
                                    <div class="navbar-login">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="text-center">
                                                    <span class="glyphicon glyphicon-user icon-size"></span>
                                                </p>
                                            </div>
                                            <div class="col-lg-8">
                                                <p class="text-left"><strong>{{ Auth::user()->fullname() }}</strong></p>
                                                <p class="text-left small">{{ Auth::user()->email }}</p>
                                                <p class="text-left">
                                                    <a href="/settings" class="btn btn-primary btn-block btn-sm">Profile</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="navbar-login navbar-login-session">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>
                                                    <a href="/logout" class="btn default-btn btn-block">Logout</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
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
            <script type="text/javascript" src="http://www.google.com/jsapi?key=AIzaSyANvZAZmHJVMI8lGIyCU4v-aduI1bhVIsg"></script> 
        
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
    </body>
</html>
