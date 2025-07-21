<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\V1\DepartmentServices;
use App\Http\Requests\V1\DepartmentStoreRequest;

class DepartmentController extends Controller
{

    public function __construct(public DepartmentServices $departmentServices){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->departmentServices->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentStoreRequest $request)
    {
        return $this->departmentServices->store($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->departmentServices->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->departmentServices->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->departmentServices->destroy($id);
    }
}
