@extends('employee.layouts.master')
   
@section('content')


<section class='dashboard'>
    
    @include('employee.inc.sidebar')



    <div class="rightBar">
        <h4 class=" font-weight-bold text-uppercase mt-3 mb-4">Employee profile </h4>


        <div class="user-form">
            <div class="left">

                <div class="ermsg"></div>
                    <div class="form-group">
                        <div class="form-item">
                            <label for=""> Name </label>
                            <input type="text" id="name" name="name" value="{{Auth::user()->name}}" class="form-control">
                            <input type="hidden" id="codeid" name="codeid" value="{{Auth::user()->id}}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-item">
                            <label for=""> Contact Number </label>
                            <input type="text" id="phone" name="phone" value="{{Auth::user()->phone}}" class="form-control">
                        </div>
                        <div class="form-item">
                            <label for="">Email</label>
                            <input type="email" id="email" name="email" value="{{Auth::user()->email}}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-item">
                            <label for=""> Address </label>
                            <textarea name="address" id="address" cols="30" rows="3" class="form-control"> {{Auth::user()->address}}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-item">
                            <button class="btn-form updateEmplyBtn" id="updateEmplyBtn">Update</button>
                        </div>
                    </div>

            </div>
            <div class="right">
                <div class="addProfile mt-5">
                    <img src="@if (Auth::user()->image) {{asset('images/thumbnail/'.Auth::user()->image)}}
                    @else https://learnyzen.com/wp-content/uploads/2017/08/test1-481x385.png @endif " alt="">
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg" class="profile-upload">
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
      var url = "{{URL::to('/employee/profile')}}";
      //console.log(url);
      $(".updateEmplyBtn").click(function(){
           var file_data = $('#image').prop('files')[0];
            if(typeof file_data === 'undefined'){
                file_data = 'null';
            }
            var form_data = new FormData();
            form_data.append('image', file_data);
            form_data.append("name", $("#name").val());
            form_data.append("email", $("#email").val());
            form_data.append("phone", $("#phone").val());
            form_data.append("address", $("#address").val());
            form_data.append('_method', 'put');
            $.ajax({
                url:url+'/'+$("#codeid").val(),
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
      $("#employeeprofile").addClass('active');
  });
</script>
@endsection