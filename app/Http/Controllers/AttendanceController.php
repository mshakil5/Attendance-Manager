<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\support\Facades\Auth;

class AttendanceController extends Controller
{
    public function showAdminAttendance()
    {
        $data = Attendance::orderby('id','DESC')->get();
        return view('admin.employee.allattendance',compact('data'));
    }
    public function employeeAttendance()
    {
        $todaysAttendance = Attendance::where('date', date("Y-m-d"))->where('user_id',Auth::user()->id)->first();
        return view('employee.attendance',compact('todaysAttendance'));
    }

    public function myAttendance()
    {
        $data = Attendance::where('user_id',Auth::user()->id)->get();
        return view('employee.allattendance',compact('data'));
    }

    public function employeeAttendanceStore(Request $request)
    {
        
        try{
            $data = new Attendance();
            $data->user_id = Auth::user()->id;
            $data->starting_time = date("H:i:s");
            $data->date = date("Y-m-d");
            $data->created_by= Auth::user()->id;
            $data->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Attendance Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);

        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);

        }
    }

    public function employeeAttendanceCloseStore(Request $request)
    {
        $where = [
            'user_id'=>Auth::user()->id,
            'date'=>date("Y-m-d")
        ];
        
        try{
            $data = Attendance::where($where)->get()->first();
            $data->user_id = Auth::user()->id;
            $data->closing_time = date("H:i:s");
            $data->date = date("Y-m-d");
            $data->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Attendance Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);

        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);

        }
    }
}
