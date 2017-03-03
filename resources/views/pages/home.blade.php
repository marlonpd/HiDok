@extends('layout')

@section('content')
<div class="container">
    <div class="row slider-search-pnl">
        <div class="col-md-9 slider-pnl nopadding">
            <ul class="bxslider">
              <li><img width="100%" height="100%" src="/images/slider/tree_root.jpg" title="Funky roots" /></li>
              <li><img width="100%" height="100%" src="/images/slider/hill_road.jpg" title="The long and winding road" /></li>
              <li><img width="100%" height="100%" src="/images/slider/trees.jpg" title="Happy trees" /></li>
            </ul>
        </div>

        <div class="col-md-3 nopadding" >
            <div class="create-account-pnl">
                <div class="create-patient-pnl row">
                    <span class="fa-stack fa-lg fa-3x">
                      <i class="fa fa-circle fa-stack-2x icon-background1"></i>
                      <i class="fa fa-user fa-stack-1x" fa-3x aria-hidden="true"></i>
                    </span><span class="lbl patient">Patient</span> 
                      <a href="/patient/register" class="default-btn">Create Account</a>
                </div>
                <div class="create-doctor-pnl row">
                    <span class="fa-stack fa-3x fa-lg">
                      <i class="fa fa-circle fa-stack-2x icon-background1"></i>
                      <i class="fa fa-user-md fa-stack-1x" aria-hidden="true"></i>
                    </span><span class="lbl doctor">Doctor</span> 
                    <a href="/doctor/register" class="default-btn">Create Account</a>
                </div>

                <h4>Search for</h4>
            </div>

            <div class="search-panel">
                <div class="col-sm-12 nopadding">
                  
                    <div class="col-xs-3  nopadding"> <!-- required for floating -->
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs tabs-left search-tabs-left">
                        <li class="active"><a href="#home" data-toggle="tab">Doctor</a></li>
                        <li class=""><a href="#profile" data-toggle="tab">Hospital</a></li>
                        <li class=""><a href="#messages" data-toggle="tab">Pharmacy</a></li>
                        <li><a href="#settings" data-toggle="tab">Laboratory</a></li>
                      </ul>
                    </div>

                    <div class="col-xs-9">
                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div class="tab-pane active doctor" id="home">
                                <form  action="/search" method="get">
                                  <input type="hidden" name="account" value="doctor">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="specialization" name="specialization" placeholder="Specialization">
                                  </div>

                                   <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                  </div>

                                   <div class="form-group">
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Location">
                                  </div>
                                   <div class="btn-holder"> <button type="submit" class="btn btn-default">Submit</button></div> 
                                 
                                </form>
                        </div>
                        <div class="tab-pane" id="profile">
                               <form action="/search" method="get">
                                   <input type="hidden" name="account" value="hospital">
                                   <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Name" name="name" >
                                  </div>

                                   <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Location" name="location">
                                  </div>
                                   <div class="btn-holder"> <button type="submit" class="btn btn-default">Submit</button></div> 
                                 
                                </form>

                        </div>
                        <div class="tab-pane " id="messages">
                                <form action="/search" method="get">
                                   <input type="hidden" name="account" value="pharmacy">
                                   <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Name" name="name">
                                  </div>

                                   <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Location" name="location">
                                  </div>
                                   <div class="btn-holder"> <button type="submit" class="btn btn-default">Submit</button></div> 
                                 
                                </form>
                        </div>
                        <div class="tab-pane" id="settings">
                               <form action="/search" method="get">
                                   <input type="hidden" name="account" value="laboratory">
                                   <div class="form-group" >
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Name" name="name">
                                  </div>

                                   <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Location" name="location">
                                  </div>
                                   <div class="btn-holder"> <button type="submit" class="btn btn-default">Submit</button></div> 
                                 
                                </form>
                        </div>
                      </div>
                    </div>

                    <div class="clearfix"></div>

                  </div> 
            </div>
        </div>
    </div>

    <div class="download-pnl">
        <h4>The quickest access to healthcare</h4>
        <p>The quickest access to healthcare</p>
        <div class="download-btns">
            <img src="images/btnappstore.png" width="170">
            <img src="images/btnappstoregoogle.png" width="170">
        </div>
    </div>
</div>
@endsection




@section('javascripts')
    <script>
        

        var childMixin = {
            mounted(){
                $('.bxslider').bxSlider({
                  mode: 'fade',
                  captions: true,
                  slideSelector: '',
                    infiniteLoop: true,
                    hideControlOnEnd: false,
                    speed: 500,
                    easing: null,
                    slideMargin: 0,
                    startSlide: 0,
                    randomStart: false,
                    captions: false,
                    ticker: false,
                    tickerHover: false,
                    adaptiveHeight: false,
                    adaptiveHeightSpeed: 500,
                    video: false,
                    useCSS: true,
                    preloadImages: 'visible',
                    responsive: true,
                    controls: false,
                });
                    
            },

        };
    </script>
@endsection