<?php

namespace App\Http\Controllers\V1;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProfileStoreRequest;
use App\Http\Requests\V1\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Profile::with('user')->paginate(10);
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
    public function store(ProfileStoreRequest $profileStoreRequest)
    {
        return $profileStoreRequest->store();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = Profile::with('user')->whereId($id)->firstOrFail();

        return $profile;
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
    public function update(ProfileUpdateRequest $profileUpdateRequest, string $id)
    {
        return $profileUpdateRequest->update($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profile = Profile::findOrFail($id);



        $profile->delete();


        return response([
            'message' => 'Profile Deleted'
        ]);
    }
}
