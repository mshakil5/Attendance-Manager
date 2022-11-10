@extends('layouts.master')
   
@section('content')


<section class='dashboard'>
    
    @include('admin.inc.sidebar')

    <div class="rightBar">

        <div class="d-flex justify-content-end">
            <button class="btn-form float-right" id="newBtn" >Add New Employee</button>
        </div>


        <div id="addThisFormContainer">

            <h4 class=" font-weight-bold text-uppercase mt-3 mb-4">Employee Information </h4>


            <div class="user-form">
                <div class="left">

                    <div class="ermsg" id="ermsg"></div>

                    {!! Form::open(['url' => 'admin/master/create','id'=>'createThisForm']) !!}
                    {!! Form::hidden('codeid','', ['id' => 'codeid']) !!}
                    @csrf

                        <div class="form-group">
                            <div class="form-item">
                                <label for=""> Name </label>
                                <input type="text" id="name" name="name" value="" class="form-control">
                                <input type="hidden" id="codeid" name="codeid" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-item">
                                <label for=""> Contact Number </label>
                                <input type="text" id="phone" name="phone" value="" class="form-control">
                            </div>
                            <div class="form-item">
                                <label for="">Email</label>
                                <input type="email" id="employeeemail" name="employeeemail" value="" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-item">
                                <label for=""> Address </label>
                                <textarea name="address" id="address" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-item">
                                <hr>
                                <input type="button" id="addBtn" value="Create" class="btn btn-primary">
                                <input type="button" id="FormCloseBtn" value="Close" class="btn btn-warning">
                            </div>
                        </div>

                        {!! Form::close() !!}

                </div>
                
            </div>

        </div>
                <div id="contentContainer">
                    <h4 class=" font-weight-bold text-uppercase mt-3 mb-4">Employee list  </h4>
                        
                    <div class="row section-divider border border-1">
                        <form  action="{{route('admin.employeesearch')}}" method ="POST">
                            @csrf
                        <div class="form-group">
                            
                            <div class="form-item">
                                <input type="text" class="form-control" id="employeesearch" name="employeesearch" placeholder="Search here">
                            </div>
                            <div class="form-item">
                                <button type="submit" class="btn" name="search" title="Search"><img src="https://img.icons8.com/android/24/000000/search.png"/></button>
                            </div> 
                        </div>
                    
                    </form>
                    <div class="col-md-12">
                        <table class="table table-custom shadow-sm table-hoverd">
                        <thead>
                            <tr>
                                <th>Full Name</th> 
                                <th>Email </th>
                                <th>Contact Number</th>
                                <th>Address</th>
                                <th>Image</th>
                                <th>Action </th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->address }}</td>
                                <td style="text-align: center">
                                    <div class="addProfile mt-5">
                                        @if ($item->image)
                                        <img src="{{asset('images/thumbnail/'.$item->image)}}" alt="">
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <a id="EditBtn" rid="{{$item->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:20px;"></i></a>
                                    <a id="deleteBtn" rid="{{$item->id}}">
                                    <span class="iconify fs-3 text-danger" data-icon="fluent:delete-20-regular"></span>
                                    </a>
                                    
                                </td> 
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
    <script>
        $(document).ready(function () {
            $("#addThisFormContainer").hide();
            $("#newBtn").click(function(){
                clearform();
                $("#newBtn").hide(100);
                $("#addThisFormContainer").show(300);

            });
            $("#FormCloseBtn").click(function(){
                $("#addThisFormContainer").hide(200);
                $("#newBtn").show(100);
                clearform();
                 window.setTimeout(function(){location.reload()},200)
            });
            //header for csrf-token is must in laravel
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //
            var url = "{{URL::to('/admin/employee')}}";
            var storeurl = "{{URL::to('/admin/employee-store')}}";
            // console.log(url);
            $("#addBtn").click(function(){
            //   alert("#addBtn");
                if($(this).val() == 'Create') {

                    var form_data = new FormData();
                    form_data.append("name", $("#name").val());
                    form_data.append("phone", $("#phone").val());
                    form_data.append("employeeemail", $("#employeeemail").val());
                    form_data.append("address", $("#address").val());
                    $.ajax({
                      url: storeurl,
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
                }
                //create  end
                //Update
                if($(this).val() == 'Update'){

                    
                    var form_data = new FormData();
                    form_data.append("name", $("#name").val());
                    form_data.append("phone", $("#phone").val());
                    form_data.append("employeeemail", $("#employeeemail").val());
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
                }
                //Update
            });
            //Edit
            $("#contentContainer").on('click','#EditBtn', function(){
                //alert("btn work");
                codeid = $(this).attr('rid');
                info_url = url + '/'+codeid+'/edit';
                $.get(info_url,{},function(d){
                    populateForm(d);
                    pagetop();
                });
            });
            //Edit  end
            //Delete
            $("#contentContainer").on('click','#deleteBtn', function(){
                if(!confirm('Sure?')) return;
                codeid = $(this).attr('rid');
                info_url = url + '/'+codeid;
                $.ajax({
                    url:info_url,
                    method: "GET",
                    type: "DELETE",
                    data:{
                    },
                    success: function(d){
                        if(d.success) {
                            alert(d.message);
                            location.reload();
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
            });
            //Delete 
            function populateForm(data){
                $("#name").val(data.name);
                $("#phone").val(data.phone);
                $("#employeeemail").val(data.email);
                $("#address").val(data.address);
                $("#codeid").val(data.id);
                $("#addBtn").val('Update');
                $("#addThisFormContainer").show(300);
                $("#newBtn").hide(100);
            }
            function clearform(){
                $('#createThisForm')[0].reset();
                $("#addBtn").val('Create');
            }

        });

        

    </script>



    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#employee").addClass('active');
        });
    </script>
@endsection