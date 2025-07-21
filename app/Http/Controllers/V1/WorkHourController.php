<?php

namespace App\Http\Controllers\V1;

use App\Models\WorkHour;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkHourStoreRequest;
use App\Http\Requests\V1\WorkHourUpdateRequest;

class WorkHourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return WorkHour::paginate(10);
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
    public function store(WorkHourStoreRequest $workHourStoreRequest)
    {
        return $workHourStoreRequest->store();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return WorkHour::findOrFail($id);
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
    public function update(WorkHourUpdateRequest $workHourUpdateRequest, string $id)
    {
        return $workHourUpdateRequest->update($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return WorkHour::findOrFail($id)->delete();
    }
}
