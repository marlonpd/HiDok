<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" id="csrf-token">

        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <link rel="stylesheet" type="text/css" href="/css/all.css">
        <link rel="stylesheet" type="text/css" href="/css/theme.css">

    </head>
    <body >
      <div id="app">
     
              @include('partials.nav')
              <div class="main-container" >
                  <div id="wrapper" class="toggled-2">
                      @if (Auth::check())
                        @include('partials.sidebar')
                      @endif
                      <div id="page-content-wrapper">
                        @yield('content')
                      </div>
                  </div>
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
            <script type="text/javascript" src="/js/socket.io/socket.io-1.4.5.js"></script> 
       
            @yield('javascripts')

            <script type="text/javascript">

              var socket = io.connect("{!! env('APP_DOMAIN') !!}:3000");

              function initMenu() {
                $('#menu ul').hide();
                $('#menu ul').children('.current').parent().show();
                //$('#menu ul:first').show();
                $('#menu li a').click(
                  function() {
                    var checkElement = $(this).next();
                    if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                      return false;
                      }
                    if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                      $('#menu ul:visible').slideUp('normal');
                      checkElement.slideDown('normal');
                      return false;
                      }
                    }
                  );
                }
              $(document).ready(function() {initMenu();
                 $("#menu-toggle").click(function(e) {
                  e.preventDefault();

                  $("#wrapper").toggleClass("toggled");
              });
              $("#menu-toggle-2").click(function(e) {
                  e.preventDefault();
             
                  $("#wrapper").toggleClass("toggled-2");
                  $('#menu ul').hide();
              });
          
              
              }); 
               

              var main = {

                mounted(){    
                },

                created: function() {    
                  @if (Auth::check())
                     this.fetchConstants();
                     this.setAuthUser('{!! Auth::user() !!}');    
                     this.fetchUnReadNotifications();     
                  @endif 
                },

                data: function(){
                    return {
                      dev : null,
                      id : null,
                      authUser : {},
                      unReadNotification : {},
                      notifications : {},
                      unReadNotificationCount : 0,
                      newNotification : {},
                      APP_DOMAIN: "{!! env('APP_DOMAIN') !!}",
                    }
                },

                methods:{
                  setAuthUser : function(authUser){
                    this.authUser = JSON.parse(authUser);
                  },

                  fetchUnReadNotifications: function(){
                    this.$http.get('/api/notifications/unread/get', function(data){
                      this.unReadNotification = data['notifications'];
                      this.unReadNotificationCount = data['unread_notification_count'];
                    });
                  },

                  fetchNotifications: function(){
                    this.$http.get('/api/notifications/get', function(data){
                      this.notifications = data['notifications'];
                    });
                  },

                  viewNotifications:function(){
                    this.unReadNotificationCount = 0;
                    this.$http.post('/api/mark/read/notification/post', this.authUser ,function(data){
                        if(data['status'] == 'success'){
                          this.unReadNotificationCount = 0;
                        }
                    });
                  },
                }
              };



             


            
            </script>
            
            <script src="/js/app.js"></script>
    </body>
</html>
