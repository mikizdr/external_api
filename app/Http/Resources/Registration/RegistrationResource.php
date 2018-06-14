<?php

namespace App\Http\Resources\Registration;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Activity;

class RegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user'      => User::find($this->user_id)->first_name . " " . User::find($this->user_id)->last_name,
            'activity'  => Activity::find($this->activity_id)->name,
        ];
    }
}
