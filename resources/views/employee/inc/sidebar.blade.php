<div class="leftBar" id="sidebar">
    <div class="slide" onclick="slide()"> <span class="iconify" data-icon="ion:log-in-outline"
            data-inline="false"></span> </div>
    <div class="sideMenu">
        <div class="profile w-100 d-flex justify-content-center">
            <img src="@if (Auth::user()->image) {{asset('images/thumbnail/'.Auth::user()->image)}}
            @else https://learnyzen.com/wp-content/uploads/2017/08/test1-481x385.png @endif "
                style="border-radius: 50%; width:90px; height:90px;">
                
        </div>
        <div class="profile w-100 d-flex justify-content-center">
            <h5>{{Auth::user()->name}}</h5>               
        </div>
        @if (isset(\App\Models\EmployeeDetail::where('user_id', Auth::user()->id)->first()->designation))
        <div class="profile w-100 d-flex justify-content-center mb-4">
            <h5>{{ \App\Models\EmployeeDetail::where('user_id', Auth::user()->id)->first()->designation }}</h5>               
        </div>
        @endif
        
        <p>general</p>
        <ul class="menu-items">
            <li><a href="{{ route('employee.home')}}"><span class="iconify icon" data-icon="ant-design:dashboard-filled"
                        data-inline="false"></span></span> dashboard</a></li>
            {{-- <li><a href=""><span class="iconify icon" data-icon="ant-design:heart-filled"
                        data-inline="false"></span> donations</a></li>
            <li><a href=""><span class="iconify icon" data-icon="entypo:leaf" data-inline="false"></span>
                    Mint</a></li> --}}
        </ul>


        <p>Employee</p>
        <ul class="menu-items">
            <li><a href="{{ route('employee.attendance')}}"><span class="iconify icon" data-icon="whh:managedhosting" data-inline="false"></span> Attendance</a></li>
            <li><a href="{{ route('employee.myattendance')}}"><span class="iconify icon" data-icon="whh:managedhosting" data-inline="false"></span> Show My Attendance</a></li>
        </ul>



        <p>Account</p>
        <ul class="menu-items">
            
            <li><a href="{{ route('employee.profile') }}"><span class="iconify icon" data-icon="ant-design:dashboard-filled" data-inline="false"></span>profile</a></li>
            <li><a href="{{ route('employee.password') }}"><span class="iconify icon" data-icon="ant-design:setting-filled"
                data-inline="false"></span> Change Password</a></li>
            <li><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="iconify icon" data-icon="fa:sign-out" data-inline="false"></span> sign out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                
                </li>

        </ul>
    </div>
</div>