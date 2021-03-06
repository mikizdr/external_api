Laravel RESTful API service for market places 
================================================

[![Latest Stable Version](https://poser.pugx.org/laravel/laravel/v/stable)](https://packagist.org/packages/laravel/laravel)
[![Latest Unstable Version](https://poser.pugx.org/laravel/laravel/v/unstable)](https://packagist.org/packages/laravel/laravel)
[![License](https://poser.pugx.org/laravel/laravel/license)](https://packagist.org/packages/laravel/laravel)

## Introduction

This service is intended for third party software for marketplaces to consume these APIs and to get required resources. The access is granted ONLY by club owners and other users can't login to this service. Granting access to marketplaces is handled by OAuth 2.0 that comes with Laravel 5.6 as laravel/passport package. In that way, only OAuth clients with a valid OAuth api token and secret ID is authorized to get these resources. Some of the Fitmanager's users can be owner of several clubs and by granting access, marketplace can consume resources for every of clubs whose owner granted access and that are valid (active) club for Fitmanager. At any time access for OAuth clients can be edited, deleted or revoked.

From above mentioned, marketplaces can view activities for the clubs for which they have access. Activities also can be filtered by different parameters via URL parameters. Visitors of marketplace's webistes can register themselves for the activities. For that purpose CRUD operations are implemented for registering of users for activities. In this way, the existing and active users of Fitmanager can be registered as well as new unkown user and in this case a new user is created in the system

## Installation

The next steps explain how to insall the application locally. As far as deploying, it can be done in the same way as every other Laravel application.

### Application
Clone or download the repository. After that run the command `composer install` from the root directory. Create .env file and enter credential for mysql database or copy and rename the existing file .env.example. In the application requires a APP_KEY run:
```
php artisan key:generate
```
to create a new base64 key for application.
If you want to run application from the local folder just simple run command:
```
php artisan serve
``` 
> NOTE: if you want application to be ran on a certain port (e.g. 3000), run the command `php artisan serve --port=3000`.
The application can be also served from any web server.

### OAuth 2.0 server
OAuth 2.0 server is implemented through Laravel Passport. Follow [Laravel Passport](https://laravel.com/docs/5.6/passport) tutorial for every detail about OAuth2 server implementation and settings.

## Development

### Database

The application is connected to Fitmanager DB and credentials are stored in .env file. After basic installation of the application, it is neccessary to run 
```
php artisan migrate
```
to install all tables for OAuth server as well as some changes to columns in the existing tables how the application could work. (If there is any doubt about migrations feel free to ask me about details but I was trying to comment every block of code in the application.)

### OAuth implementation

OAuth server relies on the tables with prefix oatuh_. Those tables are created after 
```
php artisan migrate
```
It is also required to run the command 
```
php artisan passport:install
``` 
This command will create the encryption keys needed to generate secure access tokens. In addition, the command will create "personal access" and "password grant" clients which will be used to generate access tokens.
After creating tables, in User model is added ``Laravel\Passport\HasApiTokens`` triat.
```php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Models\Organization;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'email', 'password', 'first_name', 'last_name', 'birth_date', 'last_message_view', 'pwd_change_date',
    ];
```
This trait will provide a few helper methods to your model which allow you to inspect the authenticated user's token and scopes.

#### Frontend quick start 

>NOTE: Follow the tutorial for [quick start](https://laravel.com/docs/5.6/passport#frontend-quickstart).

To publish the Passport Vue components, use the `vendor:publish` Artisan command:
```
php artisan vendor:publish --tag=passport-components
```
After registering the components, make sure to run `npm run dev` to recompile your assets. 


### Authentication and authorization

As mentioned above, **only** club owners have authorization to grant access to third party software to access resources and because of that **only** club owners can login to this service. Middleware `\App\Http\Middleware\CheckOwner` is registered in `Kernel.php` and it is called on every API request. Middleware is doing two actions: 1. Checks the ownerships and if so 2. checks whether the client has rights to require a certain resources. This middleware calls `App\Services\CheckOwnershipService` that validate checks if HTTP header contains OAuth secret key and if that key is properely connected to the user (club owner) who granted access. The connection is checked through `objectlinks` table. If there is valid user that is owner of one ore more clubs, method `CheckOwnershipService::returnOrganizationIds()` returns all ids of the clubs. It is important how the application could decide if e.g. required activity data are in the scope of that club(s). In that way, marketplace software can't require other resources but only those for which it has a valid OAuth API key and OAuth Secret ID. Secret ID is located in club owner's dashboard when he is logged in the service. A valid OAuth API token is required how external service can generally consume APIs and Secret ID is required to filter resources. 

Because of above mentioned, HTTP header of any request **MUST** contain:
```
Accept        :application/json
Content-Type  :application/json
Authorization :Bearer {{api_key}}
oauth_secret  :{{oauth_secret}}
```
(this can be used as preset for HTTP request's header and can be inserted through `Bulk Edit` (copy/paste) in [Postman](https://www.getpostman.com/) when testing APIs).

### Models, Views, Controllers

Models that are created for this services are `Activity`, `Organization` and `Registration`. They are linked to the corresponding tables: `activities`, `organizations` and `registrations`. 
Views are default Laravel views that comes with `php artisan make:auth` command.
All controllers in the application are of REST type. Unused method can be activated when it's needed. 
`ActivityController` contains `index` method that is used to fetch a collection of activities and to filter activities at the same time by next parameters:
```
organizer_ref, name, is_day_event, start_date, zipcode, city, region, lat, lng, allow_freetrial, from_date, to_date, 
```
With this, the URL for GET request should look like this: e.g. `{base_url}/api/activities?start_date=2018-08-15&allow_freetrial=1`.
`show` method in `ActivityController` is used to fetch a single activity.

### Routes

All routes are grouped together within protected route group with middleware `auth:api` and because of that every request **MUST** contain a valid OAuth API token. The list of all existing routes in the application can be seen with command `php artisan route:list`. There are two main API resource routes, activities and registrations with implicit route model binding. Other routes are for users login and OAuth authentication.

### Responses and transformers

All responses are in JSON format. For activities there are two types of resources: `ActivityCollection` and `ActivityResource`. The former is used to transform (adjust) the form of JSON reponse when client requires a collection of activities. The latter is used to transform response when sending data in JSON format for a single activity. It's easy to add more field to every type of response if frontend require more data about resources.

### CORS

Cross-origin resource sharing (CORS) is enabled through `CORS` middleware. For quick test of CORS, there is the route `{{base_url}}/{{api_prefix}}/cors`. It can be tested from other origin (domain) by calling this URL and the respones is: 
```
{
    "CORS": "CORS is enabled!"
}
```
In this way, there shouldn't be present CORS error and also different type of requests can be made including AJAX requests.

### Validation rules

For now, including above mentioned requests about the form of HTTP header, it is included rule for registering people to some activity. For that purpose, body of request **MUST** contain an activity ID and a club ID. Validation rules are defined in `RegistrationRequest`.

### Activities URLs
### Registrations URLs
### Creating a new user
### User's role
### Club user relationship

