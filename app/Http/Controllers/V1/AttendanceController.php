<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Models\AttendanceRecord;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AttendanceCheckInRequest;
use App\Http\Requests\V1\AttendanceCheckOutRequest;


class AttendanceController extends Controller
{
    public function index()
    {
        return AttendanceRecord::with('user')->paginate(10);
    }


    public function checkIn(AttendanceCheckInRequest $request)
    {
        return $request->checkIn();
    }

    public function checkOut(AttendanceCheckOutRequest $request, $id)
    {
        return $request->checkOut($id);
    }

    public function show($id)
    {
        return AttendanceRecord::findOrFail($id);
    }

    public function destroy($id)
    {
        return AttendanceRecord::findOrFail($id)->delete();
    }

    public function currentAttendance($id)
    {
        return AttendanceRecord::where('user_id', $id)
        ->whereNull('check_out')
        ->latest()
        ->first();
    }
}
