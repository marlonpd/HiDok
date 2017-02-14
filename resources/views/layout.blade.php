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
                      <a class="navbar-brand" href="#"><img src="/images/logo.png" alt="" width="45px;" class="img-rounded img-responsive"></a>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                      <ul class="nav navbar-nav">
                        <li>
                          <a href="/"><i class="fa fa-home fa-3x"></i></a>
                        </li>
                      </ul>

                      <ul class="nav navbar-nav pull-right">
                          <li class="active">
                              <div class="box">
                            <div class="container-1">
                                <form action="/search" method="GET">  
                                   <input type="text" id="search" name="search" placeholder="Search..." />
                                   <button type="submit" class="icon">
                                      <i class="fa fa-search"></i>
                                  </button>
                                </form>
                            </div>
                          </div>

                          </li>
                        @if (!Auth::check())
                          <li class="active"><a href="#" data-title="Register" data-toggle="modal" data-target="#register"><i class="fa fa-user-circle fa-3x"></i></a></li>
                          <li><a  href="#" data-title="Login" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in fa-3x"></i></a></li>
                        @else
                          <li><a href="/logout"><i class="fa fa-sign-out fa-3x"></i></a></li>
                        @endif
                        @if (Auth::check())

                          @if(Auth::user()->is_doctor())
                              <li><a href="/schedule"><i class="fa fa-clock-o fa-3x"></i></a></li>
                              <li><a href="/feedback"><i class="fa fa-address-book fa-3x"></i></a></li>
                          @endif
                          <li><a href="/appointment"><i class="fa fa-pencil-square-o fa-3x"></i></a></li>
                          <li><a href="/settings"><i class="fa fa-cog fa-3x"></i></a></li>
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


              @include('partials.footer')
                       
              @include('partials.flash')

            </div>
            

            <script src="/js/all.js"></script>
   

            
            @yield('javascripts')

            <script type="text/javascript">
              var main = {

                data: function(){
                    return {
                      dev : null,
                      id : null
                    }
                },

                methods:{

                }
              };

            </script>
            

            <script src="/js/app.js"></script>

              <feedback></feedback>
    </body>
</html>
