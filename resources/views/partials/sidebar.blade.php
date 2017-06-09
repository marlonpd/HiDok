 <!-- Sidebar -->
<div id="sidebar-wrapper">
    <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
        <!--
        <li class="active">
            <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-dashboard fa-stack-1x "></i></span> Dashboard</a>
            <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                <li><a href="#">link1</a></li>
                <li><a href="#">link2</a></li>
            </ul>
        </li> -->
            <li>
                <a href="/home"><span class="fa-stack fa-lg pull-left"><i class="fa fa-home fa-stack-1x "></i></span>Home</a>
            </li>

        @if(Auth::user()->is_patient())
        
            <li>
                <a href="/health/history"><span class="fa-stack fa-lg pull-left"><i class="fa fa-heartbeat fa-stack-1x "></i></span>My Health History</a>
            </li>
            <li>
                <a href="/doctors"><span class="fa-stack fa-lg pull-left"><i class="fa fa-user-md fa-stack-1x "></i></span>Connections</a>
            </li>
            <li>
                <a href="/appointment"><span class="fa-stack fa-lg pull-left"><i class="fa fa-address-book fa-stack-1x "></i></span>Appointment</a>
            </li>
        @endif    
        
        @if(Auth::user()->is_doctor())
            <li>
                <a href="/appointment"> <span class="fa-stack fa-lg pull-left"><i class="fa fa-address-book fa-stack-1x "></i></span>Appointment</a>
            </li>
            <li>
                <a href="/clinic"><span class="fa-stack fa-lg pull-left"><i class="fa fa-hospital-o fa-stack-1x "></i></span>Clinics</a>
            </li>
            <li>
                <a href="/patients"><span class="fa-stack fa-lg pull-left"><i class="fa fa-users fa-stack-1x "></i></span>Patients</a>
            </li>
            <li>
                <a href="/feedback"><span class="fa-stack fa-lg pull-left"><i class="fa fa-comments fa-stack-1x "></i></span>Feedback</a>
            </li>
        @endif
    </ul>
</div><!-- /#sidebar-wrapper -->