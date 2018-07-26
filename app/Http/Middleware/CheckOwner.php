<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\CheckOwnershipService;

/**
 * Checks if the user of Fitmanager who granted access to 3rd party client (software)
 * via OAuth athorization, has valid account as an owner and if so also checks if he
 * is the owner of one or more clubs (organizations) and there status.
 */

class CheckOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $ownership = new CheckOwnershipService();
      if (! $ownership->validateOwner()[0]) {
        return response()->json([
            'error' => $ownership->validateOwner()[1]
          ]);
      }

      return $next($request);
    }
}
