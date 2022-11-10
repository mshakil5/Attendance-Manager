@extends('employee.layouts.master')
   
@section('content')


<section class='dashboard'>
    
    
    @include('employee.inc.sidebar')



    <div class="rightBar">
        <h4 class=" font-weight-bold text-uppercase mt-3 mb-4">Employee Password </h4>


        <div class="user-form">
            <div class="left">

                <div class="ermsg"></div>
                    
                
                    
                    <div class="form-group">
                        <div class="form-item">
                            <label for="">Old Password </label>
                            <input type="password" id="opassword" name="opassword" class="form-control">
                        </div>
                        
                    </div>

                    <div class="form-group">
                        <div class="form-item">
                            <label for=""> New Password </label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="form-item">
                            <label for="">Confirm Password </label>
                            <input type="password" id="confirmpassword" name="confirmpassword" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-item">
                            <button class="btn-form updatePwdBtn" id="updatePwdBtn">Update</button>
                        </div>
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
      var url = "{{URL::to('/employee/changepassword')}}";
      //console.log(url);
      $(".updatePwdBtn").click(function(){
            var form_data = new FormData();
            form_data.append("password", $("#password").val());
            form_data.append("confirmpassword", $("#confirmpassword").val());
            form_data.append("opassword", $("#opassword").val());
            
            $.ajax({
                url:url,
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                data:form_data,
                success: function(d){
                    console.log(d);
                    if (d.status == 303) {
                        $(".ermsg").html(d.message);
                        pagetop();
                    }else if(d.status == 300){
                        $(".ermsg").html(d.message);
                        window.setTimeout(function(){location.reload()},2000)
                    }
                },
                error:function(d){
                    console.log(d);
                }
            });

      });

  });
</script>


<script type="text/javascript">
  $(document).ready(function() {
      $("#password").addClass('active');
  });
</script>
@endsection