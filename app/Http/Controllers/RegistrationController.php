<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Registration\RegistrationResource;
use App\Models\Registration;
use App\Http\Resources\Registration\RegistrationCollection;
use App\Http\Requests\Registration\RegistrationRequest;
use App\Models\Activity;
use Illuminate\Support\Carbon;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RegistrationCollection::collection(Registration::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Registration\RegistrationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegistrationRequest $request)
    {
        $registration = new Registration;
        $registration->user_id = $request->user_id;
        $registration->activity_id = $request->activity_id;
        $registration->activity_date = Activity::find($request->activity_id)->start_date;
        $registration->payment_type = "";
        $registration->state = 'active';
        $registration->creation_date = Carbon::now();
        $registration->save($request->all());
        // return $activity->start_date;
        // return $request->activity_id;
        // Registration::create($request->all());
        return response()->json([
            'message' => 'The member is registered for the activity'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Registration $registration)
    {
        return new RegistrationResource($registration);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registration $registration)
    {
        return $registration;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registration $registration)
    {
        //
    }
}
