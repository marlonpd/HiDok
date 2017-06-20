<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Bootply snippet - Dropdown Search and Login</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Custom dropdown search box and login." />
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="apple-touch-icon" href="/bootstrap/img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/bootstrap/img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/bootstrap/img/apple-touch-icon-114x114.png">

<link href="/css/font-awesome.min.css" type="text/css" rel="stylesheet">








        <!-- CSS code from Bootply.com editor -->
        
        <style type="text/css">
            @import url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css');.navbar-form input, .form-inline input { width:auto;}/* end *//* custom theme */header { min-height:230px;   margin-bottom:5px;}@media (min-width: 979px) {  #sidebar.affix-top {      position: static;  }    #sidebar.affix {      position: fixed;      top: 0;      width:21.2%;  }}.affix,.affix-top {   position:static;}/* theme */body {  color:#828282;  background-color:#eee;}a,a:hover { color:#ff3333;    text-decoration:none;}.highlight-bk { background-color:#ff3333;    padding:1px;    width:100%;}.highlight { color:#ff3333;}  h3.highlight  {  padding-top:13px;    padding-bottom:14px;   border-bottom:2px solid #ff3333;}.navbar {  background-color:#ff3333;   color:#ffffff;    border:0;   border-radius:0;}.navbar-nav > li > a {   color:#fff;   padding-left:20px;    padding-right:20px;   border-left:1px solid #e8e8e8;}.navbar-nav > li:last-child > a {    border-right:1px solid #e8e8e8;}.navbar-nav > .active > a, .navbar-nav > .active > a:hover, .navbar-nav > .active > a:focus {    color: #ffffff;  background-color:transparent;}.navbar-nav > .open > a, .navbar-nav > .open > a:hover, .navbar-nav > .open > a:focus { color: #555555; background-color:transparent;   opacity:.9;}.nav .open > a {    border-color:#777777;    border-width:0;}.accordion-group { border-width:0;}.dropdown-menu {  min-width: 365px;}.accordion-heading .accordion-toggle, .accordion-inner, .nav-stacked li > a { padding-left:1px;}.caret {  color:#fff;}.navbar-toggle {  color:#fff;    border-width:0;}  .navbar-toggle:hover { background-color:#fff;}.panel { padding-left:27px;    padding-right:27px;}
        </style>
    </head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body  >
        
        <!-- Begin Navbar --><div class="navbar navbar-static">    <div class="container">      <a class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">        <span class="glyphicon glyphicon-chevron-down"></span>      </a>      <div class="nav-collapse collase">        <ul class="nav navbar-nav">            <li><a href="#" class="active"><i class="fa fa-home"></i> Home</a></li>          <li><a href="#"><i class="fa fa-building-o"></i> Clinic</a></li>          <li><a href="#"><i class="fa fa-support"></i> Appointment</a></li>        </ul>        <ul class="nav pull-right navbar-nav">          <li class="dropdown">            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-search"></i></a>            <ul class="dropdown-menu" style="padding:12px;">                <form class="form-inline">            <button type="submit" class="btn btn-default pull-right"><i class="glyphicon glyphicon-search"></i></button><Select class="btn btn-default pull-left">
        <option>Doctor</option>
         <option>Hospital</option>
         <option>Laboratory</option> 
        </Select><input class="form-control pull-left" placeholder="Search" type="text">                </form>              </ul>          </li>       

        <li><a href="" class="badge1" data-badge="27"><i class="glyphicon glyphicon-bell notification-icon"></i></a></li>

           <li class="dropdown">            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-chevron-down"></i></a>            <ul class="dropdown-menu">              <li><a href="#"><i class="fa fa-cog"></i> Login</a></li>              <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>              <li class="divider"></li>              <li><a href="#"><i class="fa fa-sign-out"></i> Logout</a></li>             </ul>          </li>          </ul>      </div>       </div></div><!-- /.navbar -->
        
        <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>


        <script type='text/javascript' src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>




                   <script src="/js/all.js"></script>
   


        
        <!-- JavaScript jQuery code from Bootply.com editor  -->



        
        <script type='text/javascript'>
        
        $(document).ready(function() {
        
            
        
        });
        
        </script>
        
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
          ga('create', 'UA-40413119-1', 'bootply.com');
          ga('send', 'pageview');
        </script>
        
        
        <style>
            .ad {
              position: absolute;
              bottom: 70px;
              right: 48px;
              z-index: 992;
              background-color:#f3f3f3;
              position: fixed;
              width: 155px;
              padding:1px;
            }
            
            .ad-btn-hide {
              position: absolute;
              top: -10px;
              left: -12px;
              background: #fefefe;
              background: rgba(240,240,240,0.9);
              border: 0;
              border-radius: 26px;
              cursor: pointer;
              padding: 2px;
              height: 25px;
              width: 25px;
              font-size: 14px;
              vertical-align:top;
              outline: 0;
            }
            
            .carbon-img {
              float:left;
              padding: 10px;
            }
            
            .carbon-text {
              color: #888;
              display: inline-block;
              font-family: Verdana;
              font-size: 11px;
              font-weight: 400;
              height: 60px;
              margin-left: 9px;
              width: 142px;
              padding-top: 10px;
            }
            
            .carbon-text:hover {
              color: #666;
            }
            
            .carbon-poweredby {
              color: #6A6A6A;
              float: left;
              font-family: Verdana;
              font-size: 11px;
              font-weight: 400;
              margin-left: 10px;
              margin-top: 13px;
              text-align: center;
            }

            .badge1 {
   position:relative;
}
.badge1[data-badge]:after {
   content:attr(data-badge);
   position:absolute;
   top:7px;
   right:11px;
   font-size:.7em;
   background:green;
   color:white;
   width:18px;height:18px;
   text-align:center;
   line-height:18px;
   border-radius:50%;
   box-shadow:0 0 1px #333;
}
        </style>

        {{ $current_dir }}
    </body>
</html>