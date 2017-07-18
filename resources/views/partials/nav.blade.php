<nav class="navbar navbar-inverse navbar-top">
                    @if (Auth::check())
                         <!--sidebar menu icon -->
                          <div id="navbar-collapse-toggle-icon">
                            <ul class="nav navbar-nav">
                                <li class="active" ><button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"> <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></button></li>
                            </ul>
                          </div>
                          <!--end sidebar menu icon -->     
                    @endif
       
                  <div class="container">
                    <div class="navbar-header">
                      
                    

                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="/home"><img src="/images/logo.png" alt="" width="60px;" class="img-rounded img-responsive"><h4>{{ env('APP_NAME') }}</h4></a>
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


                        

                      </ul>

                      <ul class="nav navbar-nav pull-right">
                          @if (Auth::check())

                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Looking for? <i class="glyphicon glyphicon-search"></i></a>
                              <ul class="dropdown-menu search-menu" style="padding:12px;">
                                  <form class="form-inline" action="/search" method="get">
                                  <!--<select class="form-control pull-left" name="account">
                                    <option value="doctor">Doctor</option>
                                    <option value="hospital">Hospital</option>
                                    <option value="laboratory">Laboratory</option>
                                    <option value="pharmacy">Pharmacy</option>
                                  </select>-->
                                    <div class="col-sm-9">
                                      <input type="hidden" name="account" value="doctor">
                                      <div class="search-field">
                                        @if(!empty($specialization))
                                          <input type="text" class="form-control" id="specialization" name="specialization" placeholder="Specialization" value="{{ $specialization}}">
                                        @else
                                          <input type="text" class="form-control" id="specialization" name="specialization" placeholder="Specialization" value="">
                                        @endif
                                      </div>

                                      <div class="search-field">
                                      @if(!empty($name))
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $name}}">
                                        @else
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="">
                                        @endif
                                      </div>

                                      <div class="search-field">
                                        @if(!empty($location))
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{$location}}">
                                        @else
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="">
                                        @endif

                                      </div>
                                    </div>
                                    
                                    <div class="col-sm-3">
                                      <button type="submit" class="btn btn-default pull-right"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                    <!--<input class="form-control pull-left" placeholder="Search" type="text" name="name">-->
                                  </form>
                                </ul>
                            </li>
                          @endif
                  
                        @if (!Auth::check())
           
                          <li><a  href="#" data-title="Login" data-toggle="modal" data-target="#login"><i class="fa fa-user" aria-hidden="true"></i>Login</a></li>
                        @else
                          <li class="dropdown">
                              <a @click="viewNotifications()" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <i class="glyphicon glyphicon-bell"></i>
                                   <span v-if="unReadNotificationCount > 0" class="button__badge" v-cloak>@{{ unReadNotificationCount }}</span>
                              </a>
                              <ul class="dropdown-menu notifications notification-menu" role="menu" aria-labelledby="dLabel">
                                
                                <div class="notification-heading"><h4 class="menu-title">Notifications</h4><h4 class="menu-title pull-right hide">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4>
                                </div>
                                <li class="divider"></li>
                              <div class="notifications-wrapper">

                                <a v-for="notification in unReadNotification" class="content" :href="notification.url">  
                                  <div class="notification-item">
                                    <h4 class="item-title">@{{ notification.type | capitalize  }} - @{{ notification.created_at }}</h4>
                                    <div class="row">
                                      <div class="col-sm-3">
                                          <div class="thumbnail"><img :src="notification.sender.thumbnail" class="img-responsive user-photo"></div>
                                      </div>
                                      <div class="col-sm-9">
                                        <div class="pull-left">
                                            <p class="item-info">@{{ notification.sender.firstname | capitalize  }} @{{ notification.sender.lastname | capitalize  }}</p>
                                            <p class="item-info">@{{ notification.content }}</p>
                                        </div>
                                      </div>

                                    
                                    </div>
                                    
                                    
                                  </div>  
                                </a>

                                

                              </div>
                                <li class="divider"></li>
                                <div class="notification-footer"><h4 class="menu-title hide" >View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4></div>
                              </ul>
                          </li>



                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span> 
                                <strong>{{ ucfirst(trans(Auth::user()->firstname)) }}</strong>
                                <span class="glyphicon glyphicon-chevron-down"></span>
                            </a>
                            <ul class="dropdown-menu account-menu">
                                <li>
                                    <div class="navbar-login">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="text-center">
                                                    <div class="post-userphoto thumbnail">
                                                        <img src="{{Auth::user()->thumbnail}}" class="img-responsive user-photo">
                                                    </div>
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