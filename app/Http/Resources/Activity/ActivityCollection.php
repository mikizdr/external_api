<?php

namespace App\Http\Resources\Activity;

use App\Models\Organization;
use Illuminate\Http\Resources\Json\Resource;

class ActivityCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!empty($this->organizer_ref)) {
            $club_name = Organization::find($this->organizer_ref)->name;
        } else {
            $club_name = 'The required club doesn\'t have a name.';
        }
        return [
            'club_name'        => $club_name,
            'activity_name'    => $this->name,
            'club_id'          => $this->organizer_ref,
            'start_date_time'  => $this->start_date,
            'address'          => $this->address,
            'lat'              => $this->lat,
            'lng'              => $this->lng,
        ];
    }
}
