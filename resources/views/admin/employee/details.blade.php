@extends('layouts.master')
   
@section('content')


<section class='dashboard'>
    
    @include('admin.inc.sidebar')

    <div class="rightBar">

        <div class="d-flex justify-content-end">
            <button class="btn-form float-right" id="newBtn" >Add Employee Details</button>
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
                                <label for=""> Employee Name </label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">Please Select</option>
                                    @foreach ($employee as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="codeid" name="codeid" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-item">
                                <label for="">Salary </label>
                                <input type="number" id="salary" name="salary" class="form-control">
                            </div>
                            <div class="form-item">
                                <label for="">Joining Date</label>
                                <input type="date" id="joining_date" name="joining_date" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-item">
                                <label for=""> Designation </label>
                                <select name="designation" id="designation" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="Junior Developer">Junior Developer</option>
                                    <option value="Mid Level Developer">Mid Level Developer</option>
                                    <option value="Senior Developer">Senior Developer</option>
                                    
                                </select>
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
                    
                    <div class="col-md-12">
                        <table class="table table-custom shadow-sm table-hoverd">
                        <thead>
                            <tr>
                                <th>Full Name</th> 
                                <th>Designation </th>
                                <th>Salary</th>
                                <th>Joining Date</th>
                                <th>Action </th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->designation }}</td>
                                <td>{{ $item->salary }}</td>
                                <td>{{ $item->joining_date }}</td>
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
            var url = "{{URL::to('/admin/employee-detail')}}";
            // console.log(url);
            $("#addBtn").click(function(){
            //   alert("#addBtn");
                if($(this).val() == 'Create') {

                    var form_data = new FormData();
                    form_data.append("user_id", $("#user_id").val());
                    form_data.append("designation", $("#designation").val());
                    form_data.append("salary", $("#salary").val());
                    form_data.append("joining_date", $("#joining_date").val());
                    $.ajax({
                      url: url,
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
                    form_data.append("user_id", $("#user_id").val());
                    form_data.append("designation", $("#designation").val());
                    form_data.append("salary", $("#salary").val());
                    form_data.append("joining_date", $("#joining_date").val());
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
                $("#joining_date").val(data.joining_date);
                $("#salary").val(data.salary);
                $("#designation").val(data.designation);
                $("#user_id").val(data.user_id);
                $("#codeid").val(data.id);
                $('#user_id').prop('disabled', true);
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
            $("#employeedetails").addClass('active');
        });
    </script>
@endsection