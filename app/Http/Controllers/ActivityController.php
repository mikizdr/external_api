<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\CheckOwnershipService;
use App\Http\Resources\Activity\ActivityResource;
use App\Http\Resources\Activity\ActivityCollection;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $ownership = new CheckOwnershipService();
      return $ownership->returnOrganizationIds();

      $activities = Activity::where('organizer_ref', '=', $request->organizer_ref)->paginate(10);
      // return $activities;
      return ActivityCollection::collection($activities);
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
     * @param  Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        return new ActivityResource($activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }

    /**
     * Select activities between 2 dates.
     *
     * @param  string  $from
     * @param  string  $to
     * @return \Illuminate\Http\Response
     */
    public function activitiesBetweenDates($from, $to)
    {
        $activities = Activity::whereBetween('start_date', [$from, $to])
            // ->orWhereBetween('start_date', [$from2, $to2])
            // ->whereNotBetween('start_date', [$from3, $to3])
            ->get();
        return $activities;
    }
}
