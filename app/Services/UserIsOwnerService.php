<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * Service that checks if the user with login credentials
 * is an owner of any clubs or not.
 */

 class UserIsOwnerService
 {
   public static function isOwner(Request $request)
   {
     $user = User::whereEmail($request->email)->first();
     if ($user === null) {
       return response()->json([
         'error' => 'There is no user for these credentials'
       ]);
     }
     $links = DB::table('objectlinks')
       ->where('object_ref', $user->id)
       ->where('relation', 'member') // internal conventions for links between owner of the club and the club in objectlinks table
       ->where('is_controller', 1)
       ->where('state', 'active')
       ->get();
     if (count($links) == 0) {
       return false;
     }
     return true;
   }
 }

 /*
 NOTE: this is how login method in Illuminate\Foundation\Auth\AuthenticatesUsers trait looks like
 public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (!UserIsOwnerService::isOwner($request)) {
          return view('auth.restriction');
        }

        if ($this->attemptLogin($request)) {
          return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
*/
