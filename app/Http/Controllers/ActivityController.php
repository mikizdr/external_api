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
     * @var CheckOwnershipService
     */
    private $ownership;

    public function __construct()
    {
        $this->ownership = new CheckOwnershipService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $organizer_ref    = $request->club_id;
        $name             = $request->name;
        $is_day_event     = $request->is_day_event;
        $start_date       = $request->start_date;
        $zipcode          = $request->zipcode;
        $city             = $request->city;
        $region           = $request->region;
        $lat              = $request->lat;
        $lng              = $request->lng;
        $allow_freetrial  = $request->allow_freetrial;
        $from_date        = $request->from_date;
        $to_date          = $request->to_date;

        $club_ids = (!empty($request->club_id)) ? [$request->club_id] : $this->ownership->returnOrganizationIds();
        $activities = Activity::whereIn('organizer_ref', $club_ids)
                        ->when($organizer_ref, function ($query) use ($organizer_ref) {
                            return $query->where('organizer_ref', $organizer_ref);
                        })
                        ->when($name, function ($query) use ($name) {
                            return $query->where('name', $name);
                        })
                        ->when($is_day_event, function ($query) use ($is_day_event) {
                            return $query->where('is_day_event', $is_day_event);
                        })
                        ->when($start_date, function ($query) use ($start_date) {
                            return $query->where('start_date', $start_date);
                        })
                        ->when($zipcode, function ($query) use ($zipcode) {
                            return $query->where('zipcode', $zipcode);
                        })
                        ->when($city, function ($query) use ($city) {
                            return $query->where('city', $city);
                        })
                        ->when($region, function ($query) use ($region) {
                            return $query->where('region', $region);
                        })
                        ->when($lat, function ($query) use ($lat) {
                            return $query->where('lat', $lat);
                        })
                        ->when($lng, function ($query) use ($lng) {
                            return $query->where('lng', $lng);
                        })
                        ->when($allow_freetrial, function ($query) use ($allow_freetrial) {
                            return $query->where('allow_freetrial', $allow_freetrial);
                        })
                        ->when($from_date, function ($query) use ($from_date, $to_date) {
                            return $query->whereBetween('start_date', [$from_date, $to_date]);
                        })
                        ->paginate(5);
	
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
        if (!in_array($activity->organizer_ref, $this->ownership->returnOrganizationIds()->toArray())) {
            return response()->json([
                'error' => 'You have no credentials for the details about required activity.'
            ]);
        }
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
}
