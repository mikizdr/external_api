<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Registration extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'activity_id',
        'activity_date',
        'payment_type',
        'payment_product',
        'payment_product_id',
        'payment_exceeded',
        'state',
        'creator_id',
        'creation_date',
        'present',
        'approver_id',
        'approval_date',
        'is_migrated',
        'notes',
    ];

    /**
     * @var boolean
     */
    public $timestamps = false;
}
