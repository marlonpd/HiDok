<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiDok</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <link rel="stylesheet" type="text/css" href="/css/all.css">
    </head>
    <body>

               <nav class="navbar navbar-inverse navbar-top">
                  <div class="container">
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="#">HiDok</a>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                      <ul class="nav navbar-nav">
                        <li class="active"><a href="/">
                        <i class="fa fa-home fa-2x"></i>
                        </a></li>
                     
                      </ul>

                      <ul class="nav navbar-nav pull-right">
                        <li class="active"><a href="/register"><i class="fa fa-user-circle fa-2x"></i></a></li>
                        <li><a href="/login"><i class="fa fa-sign-in fa-2x"></i></a></li>
                        <li><a href="/logout"><i class="fa fa-sign-out fa-2x"></i></a></li>
                        <li><a href="/settings"><i class="fa fa-cog fa-2x"></i></a></li>
                        
                      </ul>

                    </div><!--/.nav-collapse -->
                  </div>
                </nav>
                
            <div class="main-container">

                @yield('content')
            
            </div>

            @include('partials.footer')
            <script src="/js/all.js"></script>
            
            @include('partials.flash')
            @yield('javascripts')
    </body>
</html>
