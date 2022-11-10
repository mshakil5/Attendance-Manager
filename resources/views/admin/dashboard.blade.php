@extends('layouts.master')
   
@section('content')


<section class='dashboard'>
    
    @include('admin.inc.sidebar')

    <div class="rightBar p-4">
        
        <div class="row report-section shadow-sm">
            <div class="report-box">
                <div class="title">Total Employee</div>
                <div class="amount">{{ \App\Models\User::where('is_admin','=','0')->count()}} </div>
            </div>
            <div class="report-box">
                <div class="title">Today Present</div>
                <div class="amount">{{ \App\Models\Attendance::where('date','=', date("Y-m-d"))->count()}} </div>
            </div>
            <div class="report-box">
                <div class="title">Today Absent</div>
                <div class="amount"> {{ \App\Models\User::where('is_admin','=','0')->count() - \App\Models\Attendance::where('date','=', date("Y-m-d"))->count()}} </div>
            </div>
            
        </div>

        <div id="contentContainer">
            <div class="row">
                <div class="col-md-6"> 
                    <h4 class=" font-weight-bold text-uppercase mt-3 mb-4">Todays  Attendance  Report</h4>
                    <div class="row section-divider border border-1">
                        <table class="table table-custom shadow-sm table-hoverd">
                        <thead>
                            <tr>
                                <th>Full Name</th> 
                                <th>Date </th>
                                <th>Starting Time</th>
                                <th>Closing time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Models\Attendance::where('date', date("Y-m-d"))->get() as $item)
                            <tr>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->starting_time }}</td>
                                <td>{{ $item->closing_time }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
            </div>
            
        </div>

        </div>
    </div>
    {{-- <iconify-icon icon="mi:call"></iconify-icon> --}}
</section>



@endsection