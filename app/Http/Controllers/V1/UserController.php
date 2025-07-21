<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UserStoreRequest;
use App\Http\Requests\V1\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::with('profile', 'department')->paginate(10);
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
    public function store(UserStoreRequest $userStoreRequest)
    {
        return $userStoreRequest->store();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::with('profile', 'department')->findOrfail($id);
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
    public function update(UserUpdateRequest $userUpdateRequest, string $id)
    {
        return $userUpdateRequest->update($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return User::with('profile', 'department')->findOrfail($id)->delete();
    }

    public function toggleStatus(string $id, Request $request)
    {
        $user = User::with('profile', 'department')->findOrfail($id);
        $user->update([
            'status' => $request->status
        ]);
        return $user->refresh();
    }

    public function updateDepartment(string $id, Request $request)
    {
        $user = User::with('profile', 'department')->findOrfail($id);

        $user->update([
            'department_id' => $request->department['id']
        ]);
        return $user->refresh();
    }
}
