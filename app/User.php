<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Models\Club;

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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Default values for model
     * 
     * @var array
     */
    public $attributes = [
        'account_state' => -10,
        'creation_date' => '2018-07-19',
        'salt'          => 'argsd',
        'creator_id'    => 1,
        'pwd_change_key'=> '5a43c32ba21d3',
    ];

    /**
     * Illuminate\Database\Eloquent\Relations\BelongsToMany|Club
     */
    public function clubs()
    {
        return $this->belongsToMany(Club::class)
            ->withTimestamps();
    }
}
