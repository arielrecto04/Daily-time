<?php

namespace App\Http\Controllers\V1;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LeaveTypeStoreRequest;
use App\Http\Requests\V1\LeaveTypeUpdateRequest;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LeaveType::paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeaveTypeStoreRequest $request)
    {
        return $request->store();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return LeaveType::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeaveTypeUpdateRequest $request, string $id)
    {
        return $request->update($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return LeaveType::findOrFail($id)->delete();
    }

    public function updateStatus(string $id)
    {
        $leaveType = LeaveType::findOrFail($id);
        $leaveType->update([
            'is_active' => !$leaveType->is_active
        ]);
        return $leaveType;
    }

    public function updateCredited(string $id)
    {
        $leaveType = LeaveType::findOrFail($id);
        $leaveType->update([
            'is_credited' => !$leaveType->is_credited
        ]);
        return $leaveType;
    }
}
