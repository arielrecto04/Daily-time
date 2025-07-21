<?php

namespace App\Http\Controllers\V1;

use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkScheduleStoreRequest;
use App\Http\Requests\V1\WorkScheduleUpdateRequest;
use App\Models\UserWorkSchedule;

class WorkScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return WorkSchedule::with('workHours')->paginate(10);
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
    public function store(WorkScheduleStoreRequest $workScheduleStoreRequest)
    {
        return $workScheduleStoreRequest->store();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return WorkSchedule::with('workHours')->findOrFail($id);
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
    public function update(WorkScheduleUpdateRequest $workScheduleUpdateRequest, string $id)
    {
        return $workScheduleUpdateRequest->update($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return WorkSchedule::findOrFail($id)->delete();
    }


    public function assignWorkScheduleToUser(string $id, Request $request)
    {
        return UserWorkSchedule::create([
            'user_id' => $request->user_id,
            'work_schedule_id' => $id,
        ]);
    }

    public function removeWorkScheduleFromUser(string $id)
    {
        return UserWorkSchedule::findOrFail($id)->delete();
    }
}
