<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Models\OvertimeApplication;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\OvertimeApplicationStoreRequest;
use App\Http\Requests\V1\OvertimeApplicationUpdateRequest;

class OvertimeApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OvertimeApplication::with('user')->paginate(10);
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
    public function store(OvertimeApplicationStoreRequest $overtimeApplicationStoreRequest)
    {
        return $overtimeApplicationStoreRequest->store();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return OvertimeApplication::with('user')->findOrFail($id);
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
    public function update(OvertimeApplicationUpdateRequest $overtimeApplicationUpdateRequest, string $id)
    {
        return $overtimeApplicationUpdateRequest->update($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return OvertimeApplication::findOrFail($id)->delete();
    }
}
