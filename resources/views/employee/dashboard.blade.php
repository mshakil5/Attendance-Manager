@extends('employee.layouts.master')
   
@section('content')


<section class='dashboard'>
    
    @include('employee.inc.sidebar')



    <div class="rightBar p-4">
        <div class="row report-section shadow-sm">
            <div class="report-box">
                <div class="title">My Designation</div>
                <div class="amount">
                    @if (isset(\App\Models\EmployeeDetail::where('user_id', Auth::user()->id)->first()->designation))
                        <h5>{{ \App\Models\EmployeeDetail::where('user_id', Auth::user()->id)->first()->designation }}</h5> 
                        @else
                        Designation here
                    @endif
                </div> 
            </div>
            <div class="report-box">
                <div class="title">My Salary</div>
                <div class="amount">
                    @if (isset(\App\Models\EmployeeDetail::where('user_id', Auth::user()->id)->first()->salary))
                        <h5>{{ \App\Models\EmployeeDetail::where('user_id', Auth::user()->id)->first()->salary }}</h5> 
                        @else
                        Salary not updated
                    @endif
                </div>
            </div>
            

            

        </div>
    </div>

    
</section>



@endsection