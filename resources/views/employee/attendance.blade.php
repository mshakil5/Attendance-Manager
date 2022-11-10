@extends('employee.layouts.master')
   
@section('content')



<section class='dashboard'>
    
    @include('employee.inc.sidebar')



    <div class="rightBar p-4">
        <div class="row report-section shadow-sm">
            
            @if (empty($todaysAttendance->starting_time))
                <div class="report-box">
                    <div class="title">Starting Time</div>
                    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="amount"> <button id="startBtn" style="border: 0px; background-color: rgb(255, 255, 255); ">Press Here</button> </div>
                </div>
                
            @elseif (empty($todaysAttendance->closing_time))

            <div class="report-box">
                <div class="title">Starting Time</div>
                <div class="amount"> @if (isset($todaysAttendance->starting_time))
                    {{$todaysAttendance->starting_time }}
                @endif  </div>
            </div>

            <div class="report-box">
                <div class="title">Closing Time</div>
                <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                <div class="amount"> <button id="closeBtn" style="border: 0px; background-color: rgb(255, 255, 255); ">Press Here</button> </div>
            </div>

            @else

                <div class="report-box">
                    <div class="title">Starting Time</div>
                    <div class="amount"> {{$todaysAttendance->starting_time }} </div>
                </div>
                <div class="report-box">
                    <div class="title">Closing Time</div>
                    <div class="amount"> {{$todaysAttendance->closing_time }} </div>
                </div>

            @endif
            
            
            
            <div class="report-box" style="display: none">
                <div class="title">
                    <div id="timer">0</div>
                </div>
                <div class="amount">  
                    <button id="button" class="btn-theme">Button</button>   
                </div>
            </div>

            

        </div>
    </div>

    
</section>

@endsection

@section('script')


<script>
  $(document).ready(function(){
      //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      //
      var strturl = "{{URL::to('/employee/attendance-start')}}";
      var endurl = "{{URL::to('/employee/attendance-end')}}";
      //console.log(url);
      
        var timer = 0,
        timerInterval,
        button = document.getElementById("button");

        button.addEventListener("mousedown", function() {
            timerInterval = setInterval(function(){
                timer += 1;
                document.getElementById("timer").innerText = timer;
                console.log(timer);

            }, 500);
        });

        button.addEventListener("mouseup", function() {
            clearInterval(timerInterval);
            timer = 0;
        });


        $("#startBtn").click(function(){
            var form_data = new FormData();
            form_data.append("user_id", $("#user_id").val());
            
            $.ajax({
                url: strturl,
                method: "POST",
                contentType: false,
                processData: false,
                data:form_data,
                success: function (d) {
                    if (d.status == 303) {
                        $(".ermsg").html(d.message);
                    }else if(d.status == 300){
                        $(".ermsg").html(d.message);
                        window.setTimeout(function(){location.reload()},2000)
                    }
                },
                error: function (d) {
                    console.log(d);
                }
            });
        //create  end
    });

    $("#closeBtn").click(function(){
            
            var form_data = new FormData();
            form_data.append("user_id", $("#user_id").val());
            
            $.ajax({
                url: endurl,
                method: "POST",
                contentType: false,
                processData: false,
                data:form_data,
                success: function (d) {
                    if (d.status == 303) {
                        $(".ermsg").html(d.message);
                    }else if(d.status == 300){
                        $(".ermsg").html(d.message);
                        window.setTimeout(function(){location.reload()},2000)
                    }
                },
                error: function (d) {
                    console.log(d);
                }
            });
        //create  end
    });

  });
</script>



<script type="text/javascript">
  $(document).ready(function() {
      $("#employeeprofile").addClass('active');
  });
</script>
@endsection