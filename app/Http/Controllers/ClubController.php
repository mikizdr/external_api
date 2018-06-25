<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Http\Resources\Club\ClubResource;
use App\Http\Resources\Club\ClubCollection;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $club = ClubCollection::collection(Club::find(6)->users);

        return $club;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        return new ClubResource($club);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club  $club)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club  $club)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function showUsers(Club $club)
    {
        return ClubCollection::collection($club->users);
    }
}