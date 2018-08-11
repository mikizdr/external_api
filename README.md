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
Colone or download the repository. After that run the command:
```composer install```
from the root directory. Create .env file and enter credential for mysql database or copy and rename the existing file .env.example. In the application requires a APP_KEY run:
```php artisan key:generate```
to create a new base64 key for application.
If you want to run application from the local folder just simple run command:
```php artisan serve``` 
> NOTE: if you want application to be ran on a certain port (e.g. 3000), run the command ```php artisan serve --port=3000```
Or the application can be served from any web server.

### OAuth 2.0 server
It is implemented through Laravel Passport. Follow [Laravel Passport](https://laravel.com/docs/5.6/passport) tutorial for every detail about OAuth2 server implementation and settings.

## Development

### Database

The application is connected to Fitmanager DB and credentials are stored in .env file. After basic installation of the application, it is neccessary to run ```php artisan migrate``` to install all tables for OAuth server as well as some changes to columns in the existing tables how the application could work. (If there is any doubt about migrations feel free to ask me about details but I was trying to comment every block of code in the application.)

### OAuth authentication

OAuth server relies on the tables with prefix oatuh_. Those tables are created after ```php artisan migrate```. It is also required to run the command ```php artisan passport:install```. This command will create the encryption keys needed to generate secure access tokens. In addition, the command will create "personal access" and "password grant" clients which will be used to generate access tokens.
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
This trait will provide a few helper methods to your model which allow you to inspect the authenticated user's token and scopes

### Login
### Validation rules
### Activities URLs
### Registrations URLs
### Creating a new user
### User's role
### Club user relationship

