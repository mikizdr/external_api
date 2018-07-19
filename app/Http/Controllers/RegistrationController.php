<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Registration\RegistrationResource;
use App\Models\Registration;
use App\Http\Resources\Registration\RegistrationCollection;
use App\Http\Requests\Registration\RegistrationRequest;
use App\Models\Activity;
use Illuminate\Support\Carbon;
use App\Models\Organization;
use App\Events\CreateUserEvent;
use App\Events\AttachUserEvent;
use App\User;

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
        return $this->CheckIfUserExist($request);
        if (!Organization::find($request->club_id)) {
            return response()->json([
                'error' => 'The club you want to register for the activity doesn\'t exist'
            ]);
        }

        if ($this->CheckIfUserExist($request)){

        }


        return 'exist';
        $registration = new Registration; 
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

    protected function CheckIfUserExist(Request $request)
    {

        if (empty($request->email)) {
            # create a user with fake email address
            $fakeEmail = "Fake.User@fake.fitmanager.com";
            event(new CreateUserEvent($fakeEmail, $request));
            return response()->json([
                    'message' => 'No email'
                ]);
        } else {
                
            $user = User::where('email', $request->email)->first();

            if ($user) {
                # attach user to organization
                event(new AttachUserEvent($user));
                return $user;
            }
            # create a user and attach it to the organization
            event(new CreateUserEvent($request->email, $request));
            return response()->json([
                'message' => 'There is no user with this email'
            ]);
        }

        return false;

        // 1. no email
        // 2. email exists and already registered
        // 3. email exist and not registered
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
