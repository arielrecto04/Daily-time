<?php

namespace App\Services\V1;

use App\Models\Department;

class DepartmentServices
{
    public function index()
    {
        return Department::paginate(10);
    }

    public function store($data)
    {
        return Department::create($data);
    }

    public function update($id, $data)
    {
        return Department::find($id)->update($data);
    }

    public function destroy($id)
    {
        return Department::find($id)->delete();
    }

    public function show($id)
    {
        return Department::find($id);
    }
}
