<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Activity\FilterActivitiesCollection;

class FilterActivitiesController extends Controller
{
    /**
     * Call an endpoint in format {channel}?user_id=1&organization_id=9&affected_user_id=123&object_id=135&object_type=activity&action=some action&from_date=2018-07-04&to_date=2018-08-01
     * @link https://documenter.getpostman.com/
     * @param int $club_id id of the club (organization) - mandatory parameter
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function filterActivitiesByRequest(int $club_id, Request $request)
    {
        if (empty($club_id)) {
            return response()->json([
                'error' => 'There is ID for the club. Please provide.'
            ]);
        }

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

        $activities = DB::table('activities')
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
                    
    return FilterActivitiesCollection::collection($activities);

    return response()->json([
        'error' => 'There is no data for your request.'
    ], Response::HTTP_NOT_FOUND);
    
    }
}
