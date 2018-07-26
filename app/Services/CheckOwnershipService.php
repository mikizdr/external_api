<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Service that checks OAuth validation
 * and ownership.
 */
class CheckOwnershipService
{

  /**
   * @var OauthClient
   */
  public $client;

  /**
   * @var mixed
   */
  public $links;

  public function __construct()
  {
    $this->client = DB::table('oauth_clients')->where('secret', $_SERVER['HTTP_OAUTH_SECRET'])->first();
    $this->links = DB::table('objectlinks')
      ->where('object_ref', $this->client->user_id)
      ->where('relation', 'member') // internal conventions for links between owner of the club and the club in objectlinks table
      ->where('is_controller', 1)
      ->where('state', 'active')
      ->get();
  }

  /**
   * Chacks if the provided secret exists and if it is valid
   * as well as the ownership of the user who granted an access
   * to 3rd party software.
   *
   * @return boolean
   */
  public function validateOwner()
  {
    if (!isset($_SERVER['HTTP_OAUTH_SECRET']))
      return [
        false, 'HTTP header is not correct. Client key is not provided.'
      ];

    if ($this->client === null)
      return [
        false, 'CLIENT HAS NO CREDENTIALS'
      ];

    if (count($this->links) == 0)
      return [
        false, 'Fatal error: the user who granted access to the resources is not an owner of any clubs. Sorry but you can not use them.'
      ];

    return [true];
  }

  /**
   * Returns ids of all organizations to whom the user is owner
   * and who granted access to marketplace.\Carbon\Carbon
   *
   * @return array
   */
  public function returnOrganizationIds()
  {
    return $this->links->pluck('link_ref');
  }
}