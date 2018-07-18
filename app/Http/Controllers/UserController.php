<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\User\UserRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Club;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->last_name = $request->last_name;
        $user->save();

        return response()->json([
            'message' => 'The resource is updated successfully.'
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Test attach to many to many relationship
     */
    public function atach_user(Request $request)
    {
        $user = User::find($request->user);
        $club = Club::find($request->club);
        $club_id = $club->id;
        $user->clubs()->attach($club_id, ['role_id' => 1, 'creator_id' => 1, 'status' => 'approved']);
        return $user;
    }
}
