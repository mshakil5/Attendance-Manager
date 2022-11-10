<div class="leftBar" id="sidebar">
    <div class="slide" onclick="slide()"> <span class="iconify" data-icon="ion:log-in-outline"
            data-inline="false"></span> </div>
    <div class="sideMenu">
        <div class="profile w-100 d-flex justify-content-center mb-4">
            <img src="@if (Auth::user()->image) {{asset('images/thumbnail/'.Auth::user()->image)}}
            @else https://learnyzen.com/wp-content/uploads/2017/08/test1-481x385.png @endif "
                style="border-radius: 50%; width:90px; height:90px;">
        </div>
        <p>General</p>
        <ul class="menu-items">
            <li><a href="{{ route('admin.home') }}"><span class="iconify icon" data-icon="ant-design:dashboard-filled"
                        data-inline="false"></span></span> dashboard</a></li>
            {{-- <li><a href=""><span class="iconify icon" data-icon="ant-design:heart-filled"
                        data-inline="false"></span> donations</a></li>
            <li><a href=""><span class="iconify icon" data-icon="entypo:leaf" data-inline="false"></span>
                    Mint</a></li> --}}
        </ul>


        <p>Employee</p>
        <ul class="menu-items">
            <li><a href="{{ route('admin.attendance') }}"><span class="iconify icon" data-icon="whh:managedhosting" data-inline="false"></span> Attendance</a></li>
            <li><a href="{{ route('admin.employeelist') }}"><span class="iconify icon" data-icon="whh:managedhosting" data-inline="false"></span> Employee List</a></li>
            <li><a href="{{ route('admin.employeedetail') }}"><span class="iconify icon" data-icon="whh:managedhosting" data-inline="false"></span> Employee Details</a></li>
            <li><a href="{{ route('admin.employecontact') }}"><span class="iconify icon" data-icon="whh:managedhosting" data-inline="false"></span> Employee Contact Info</a></li>
            <li><a href="{{ route('admin.allemployee') }}"><span class="iconify icon" data-icon="entypo:leaf" data-inline="false"></span> Employee Change Password</a></li>
        </ul>



        <p>Account</p>
        <ul class="menu-items">
            
            <li><a href="{{ route('admin.profile') }}"><span class="iconify icon" data-icon="ant-design:dashboard-filled" data-inline="false"></span>profile</a></li>
            <li><a href="{{ route('admin.password') }}"><span class="iconify icon" data-icon="ant-design:setting-filled"
                        data-inline="false"></span> Change Password</a></li>
            <li><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="iconify icon" data-icon="fa:sign-out" data-inline="false"></span> sign out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                
                </li>

        </ul>
    </div>
</div>