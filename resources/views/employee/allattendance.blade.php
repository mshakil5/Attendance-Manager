@extends('employee.layouts.master')
   
@section('content')


<section class='dashboard'>
    
    @include('employee.inc.sidebar')

    <div class="rightBar">

                <div id="contentContainer">
                    <h4 class=" font-weight-bold text-uppercase mt-3 mb-4">My Attendance  </h4>
                        
                    <div class="row section-divider border border-1">
                    
                    <div class="col-md-12">
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
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ Auth::user()->name }}</td>
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

</section>

@endsection

@section('script')


<script type="text/javascript">
  $(document).ready(function() {
      $("#employeeprofile").addClass('active');
  });
</script>
@endsection