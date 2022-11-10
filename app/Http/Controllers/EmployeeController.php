<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeDetail;
Use Image;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {

        if(!empty($request->input('employeesearch'))){
            $searchdata = $request->input('employeesearch');

            $data = User::with('employeedetail')
                    ->where('name','=', $searchdata)
                    ->orWhere('email','=', $searchdata)
                    ->orWhere('phone','=', $searchdata)
                    ->orWhere('address','=', $searchdata)
                    ->Where('is_admin','=', $searchdata)
                    ->get();

        }else{
            $data = User::with('employeedetail')->where('is_admin','=', 0)->get();
        }

        return view('admin.employee.index', compact('data'));
    }

    

    public function store(Request $request)
    {
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->phone)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Contact Number \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->address)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Address \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(!empty($request->employeeemail)){
            $chkemail=User::where('email', $request->employeeemail)->count();
            if($chkemail == 1){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email has already exists.</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }
        }
        try{
            $data = new User();
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->email = $request->employeeemail;
            $data->password = Hash::make('123456');
            $data->address = $request->address; 

            $data->created_by= Auth::user()->id;
            $data->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);

        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);

        }
    }

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = User::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request, $id)
    {

        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->phone)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Contact Number \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->address)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Address \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(!empty($request->employeeemail)){
            $chkemail=User::where('email', $request->employeeemail)->whereNotIn('id', [Auth::id()])->count();
            if($chkemail == 1){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email has already exists.</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }
        }

        $data = User::find($id);
        $data->name = $request->name;
        $data->phone = $request->phone; 
        $data->email = $request->employeeemail;
        $data->password = Hash::make('123456');
        $data->address = $request->address;
        
        $data->updated_by= Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function delete($id)
    {
        if(User::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }

    public function getEmployee()
    {
        $data = User::where('is_admin','=','0')->orderby('id','DESC')->get();
        return view('admin.employee.password', compact('data'));
    }

    public function changeUserPassword(Request $request)
        {

            if(empty($request->user_id)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please select \"Employee\" field..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

            if(empty($request->password)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"New Password\" field..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

            if(empty($request->password === $request->confirmpassword)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password doesn't match.</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }


            $where = [
                'id'=>$request->user_id
            ];
            $passwordchange = User::where($where)->get()->first();
            $passwordchange->password =Hash::make($request->password);

            if ($passwordchange->save()) {
                $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password Change Successfully.</b></div>";
                return response()->json(['status'=> 300,'message'=>$message]);
            }else{
                return response()->json(['status'=> 303,'message'=>'Server Error!!']);
            }

        }


        // employee details function start here 

    public function employeedetail()
    {
        $employee = User::where('is_admin','=', 0)->get();
        $data = EmployeeDetail::orderby('id','DESC')->get();
        return view('admin.employee.details', compact('data','employee'));
    }

    public function employeedetailstore(Request $request)
    {
        if(empty($request->user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select \"Employee \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->salary)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Salary \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->joining_date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Joining date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->designation)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Designation \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(!empty($request->user_id)){
            $chkemail=EmployeeDetail::where('user_id', $request->user_id)->count();
            if($chkemail == 1){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This Employee has already exists.</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }
        }

        
        
        try{
            $data = new EmployeeDetail();
            $data->user_id = $request->user_id;
            $data->designation = $request->designation;
            $data->salary = $request->salary;
            $data->joining_date = $request->joining_date; 

            $data->created_by= Auth::user()->id;
            $data->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);

        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);

        }
    }

    public function employeedetailedit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = EmployeeDetail::where($where)->get()->first();
        return response()->json($info);
    }

    public function employeedetailupdate(Request $request, $id)
    {

        if(empty($request->user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select \"Employee \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->salary)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Salary \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->joining_date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Joining date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->designation)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please select \"Designation \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        

        $data = EmployeeDetail::find($id);
        $data->user_id = $request->user_id;
        $data->designation = $request->designation;
        $data->salary = $request->salary;
        $data->joining_date = $request->joining_date; 
        
        $data->updated_by= Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function employeedetaildelete($id)
    {
        if(EmployeeDetail::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }


    public function employecontact()
    {
        $data = User::where('is_admin','=', 0)->get();
        return view('admin.employee.contact', compact('data'));
    }






}
